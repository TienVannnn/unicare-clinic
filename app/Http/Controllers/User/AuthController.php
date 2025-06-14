<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\EditAccountRequest;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\GetPatientRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RecoverPasswordRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Jobs\ForgotPasswordJob;
use App\Jobs\VerifyEmailJob;
use App\Models\Faq;
use App\Models\MedicalCertificate;
use App\Models\Prescription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login_page()
    {
        if (auth()->check()) return redirect()->route('user.overview');
        $title = 'Đăng nhập';
        return view('user.auth.login', compact('title'));
    }

    public function register_page()
    {
        if (auth()->check()) return redirect()->route('user.overview');
        $title = 'Đăng ký tài khoản';
        return view('user.auth.register', compact('title'));
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $token = Str::random(10);
            $expiration = Carbon::now()->addDay();
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'token' => $token,
                'token_duration' => $expiration
            ]);
            DB::commit();
            VerifyEmailJob::dispatch($request->name, $request->email, $token)->delay(now()->addSecond(5));
            Session::flash('success', 'Đăng ký tài khoản thành công, Vui lòng kiểm tra email để xác thực trước khi đăng nhập');
            return redirect()->route('user.login');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Có lỗi khi đăng ký');
        }
        return redirect()->back();
    }

    public function verify_email(Request $request)
    {
        $user = User::where('token', $request->token)->first();
        if (!$user) {
            return view('user.auth.email_verify_result', [
                'status' => 'error',
                'message' => 'Xác thực thất bại, không tìm thấy email xác thực.',
                'expired' => false
            ]);
        }

        if (Carbon::now()->greaterThan($user->token_duration)) {
            return view('user.auth.email_verify_result', [
                'status' => 'error',
                'message' => 'Liên kết xác thực đã hết hạn, vui lòng yêu cầu mã xác nhận mới.',
                'expired' => true,
                'email' => $user->email
            ]);
        }

        $user->verify_email = true;
        $user->token = null;
        $user->token_duration = null;
        $user->save();
        Session::flash('success', 'Xác thực email thành công. Bạn có thể đăng nhập ngay bây giờ');
        return redirect()->route('user.login');
    }


    public function resend_email(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản với email này.');
        }
        $token = Str::random(10);
        $expiration = Carbon::now()->addDay();
        $user->token = $token;
        $user->token_duration = $expiration;
        $user->save();
        VerifyEmailJob::dispatch($user->name, $user->email, $token)->delay(now()->addSeconds(3));
        return redirect()->route('user.login')->with('success', 'Email xác thực đã được gửi lại, vui lòng kiểm tra hộp thư.');
    }

    public function login(LoginRequest $request)
    {
        try {
            $cre = [
                'email' => $request->email,
                'password' => $request->password,
                'verify_email' => 1,
            ];
            if (auth()->attempt($cre, $request->has('remember'))) {
                Session::flash('success', 'Đăng nhập thành công');
                return redirect()->route('home');
            }
            Session::flash('error', 'Tài khoản không hợp lệ hoặc chưa được xác thực');
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi đăng nhập');
        }
        return redirect()->back();
    }

    public function logout()
    {
        auth()->logout();
        Session::flash('success', 'Đăng xuất thành công');
        return redirect()->route('home');
    }

    public function delete_account()
    {
        $user = auth()->user();
        if ($user->avatar) {
            $avatarPath = public_path($user->avatar);
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }
        }
        $user->delete();
        Session::flash('success', 'Xóa tài khoản thành công');
        return redirect()->route('home');
    }

    public function overview()
    {
        $title = 'Thông tin tài khoản';
        $auth = auth()->user();
        return view('user.auth.overview', compact('title', 'auth'));
    }

    public function page_account_edit()
    {
        $title = 'Chỉnh sửa tài khoản';
        $user = auth()->user();
        return view('user.auth.edit-account', compact('title', 'user'));
    }

    public function account_edit(EditAccountRequest $request)
    {
        try {
            $user = auth()->user();
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'patient_code' => $request->patient_code
            ]);
            Session::flash('success', 'Cập nhật hồ sơ thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi chỉnh sửa');
        }
        return redirect()->back();
    }

    public function page_change_password()
    {
        $title = 'Thay đổi mật khẩu';
        return view('user.auth.change-password', compact('title'));
    }

    public function change_password(ChangePasswordRequest $request)
    {
        try {
            $user = auth()->user();
            if (Hash::check($request->now_pass, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
                Session::flash('success', 'Thay đổi mật khẩu thành công');
                return redirect()->route('user.overview');
            } else {
                Session::flash('error', 'Mật khẩu hiện tại không đúng');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi cập nhật');
        }
        return redirect()->back();
    }

    public function change_avatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);

            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
            $user->avatar = '/uploads/avatars/' . $filename;
            $user->save();

            return response()->json(['success' => true, 'avatar_url' => $user->avatar]);
        }

        return response()->json(['success' => false], 500);
    }

    public function page_forgot_password()
    {
        $title = 'Quên mật khẩu';
        return view('user.auth.forgotpassword', compact('title'));
    }

    public function forgot_password(ForgotPasswordRequest $request)
    {
        $token = Str::random(10);
        $expiration = Carbon::now()->addHour();
        $user = User::where('email', $request->email)->first();
        $user->update([
            'token' => $token,
            'token_duration' => $expiration,
        ]);
        ForgotPasswordJob::dispatch($request->email, $token)->delay(now()->addSecond(5));
        Session::flash('success', 'Mã xác nhận đã được gửi đến bạn. Vui lòng kiểm tra email');
        return redirect()->route('user.recovery')->with([
            'email' => $request->email
        ]);
    }

    public function page_recovery_password()
    {
        $email = session('email');
        $title = 'Khôi phục mật khẩu';
        return view('user.auth.recover', compact('title', 'email'));
    }

    public function recovery_password(RecoverPasswordRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user->token === $request->code) {
            if (Carbon::now()->greaterThan($user->token_duration)) {
                Session::flash('error', 'Mã xác nhận đã hết hạn, vui lòng yêu cầu mã xác nhận mới');
                return redirect()->back();
            }
            $user->update([
                'password' => Hash::make($password),
                'token' => null,
                'token_duration' => null
            ]);
            if (auth()->attempt(['email' => $email, 'password' => $password])) {
                Session::flash('success', 'Đổi mật khẩu thành công');
                return redirect()->route('home');
            }
        }
        Session::flash('error', 'Token không hợp lệ!');
        return redirect()->back();
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'password' => encrypt('google@password123')
                ]);
                Auth::login($newUser);
            }
            Session::flash('success', 'Đăng nhập thành công');
            return redirect()->route('home');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi đăng nhập' . $e->getMessage());
            return redirect()->route('user.login');
        }
    }

    public function medical_history()
    {
        $title = 'Lịch sử khám bệnh';
        $auth = auth()->user();
        if ($auth->patient && $auth->patient_code) {
            $medical_history = $auth->patient->medical_certificates()->paginate(10);
        } else {
            $medical_history = collect();
        }
        return view('user.auth.medical-history', compact('title', 'auth', 'medical_history'));
    }

    public function handle_get_patient(GetPatientRequest $request)
    {
        try {
            $auth = auth()->user();
            $auth->update([
                'patient_code' => $request->patient_code
            ]);
            Session::flash('success', 'Lấy thông tin bệnh nhân thành công');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi lấy thông tin');
        }
        return redirect()->back();
    }

    public function medical_history_detail($id)
    {
        $auth = auth()->user();
        $medical_certificate = MedicalCertificate::where('id', $id)
            ->whereHas('patient', function ($query) use ($auth) {
                $query->where('id', $auth->patient->id);
            })
            ->first();

        if (!$medical_certificate) {
            abort(403);
        }

        $title = 'Chi tiết giấy khám bệnh';
        return view('user.auth.detail-medical-history', compact('title', 'medical_certificate'));
    }

    public function prescription_detail($id)
    {
        $auth = auth()->user();

        $prescription = Prescription::where('id', $id)
            ->whereHas('medical_certificate.patient', function ($query) use ($auth) {
                $query->where('id', $auth->patient->id);
            })
            ->first();

        if (!$prescription) {
            abort(403);
        }

        $title = 'Chi tiết đơn thuốc';
        return view('user.auth.prescription-detail', compact('title', 'prescription'));
    }


    public function faq()
    {
        $faqs = Faq::where('user_id', auth()->id())->orderByDesc('id')->paginate(5);
        $title = 'Câu hỏi đã hỏi';
        return view('user.auth.faq', compact('title', 'faqs'));
    }

    public function update_faq(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        if ($faq->answer) {
            Session::flash('error', 'Câu hỏi này đã được bác sĩ trả lời');
            return redirect()->back();
        }
        $faq->question = $request->input('question');
        $faq->save();

        return redirect()->back()->with('success', 'Chỉnh sửa câu hỏi thành công!');
    }


    public function faq_delete(string $id)
    {
        $faq = Faq::findOrFail($id);
        if ($faq->answer) {
            Session::flash('error', 'Câu hỏi này đã được bác sĩ trả lời');
            return redirect()->back();
        }
        $faq->delete();
        Session::flash('success', 'Xóa câu hỏi thành công');
        return redirect()->back();
    }
}
