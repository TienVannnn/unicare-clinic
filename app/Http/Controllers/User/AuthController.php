<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\EditAccountRequest;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RecoverPasswordRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Jobs\ForgotPasswordJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            Session::flash('success', 'Đăng ký tài khoản thành công');
            return redirect()->route('user.login');
        } catch (\Exception $e) {
            Session::flash('error', 'Có lỗi khi đăng ký');
        }
        return redirect()->back();
    }

    public function login(LoginRequest $request)
    {
        try {
            $cre = $request->only('email', 'password');
            if (auth()->attempt($cre, $request->has('remember'))) {
                Session::flash('success', 'Đăng nhập thành công');
                return redirect()->route('home');
            }
            Session::flash('error', 'Email hoặc mật khẩu không đúng');
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
                'address' => $request->address
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
            'token_reset_password' => $token,
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
        if ($user->token_reset_password === $request->code) {
            if (Carbon::now()->greaterThan($user->token_duration)) {
                Session::flash('error', 'Mã xác nhận đã hết hạn, vui lòng yêu cầu mã xác nhận mới');
                return redirect()->back();
            }
            $user->update([
                'password' => Hash::make($password),
                'token_reset_password' => null,
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
}
