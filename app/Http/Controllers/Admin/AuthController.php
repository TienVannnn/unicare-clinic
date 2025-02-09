<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ForgotPasswordRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\RecoveryPasswordRequest;
use App\Jobs\ForgotPasswordJob;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login_form()
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login_form');
    }

    public function login(LoginRequest $request)
    {
        $cre = $request->only('email', 'password');
        if (auth()->guard('admin')->attempt($cre, $request->has('remember'))) {
            Session::flash('success', 'Đăng nhập admin thành công');
            return redirect()->route('admin.dashboard');
        }
        Session::flash('error', 'Email hoặc mật khẩu không đúng');
        return redirect()->back();
    }

    public function forgot_password()
    {
        $title = 'Quên mật khẩu';
        return view('admin.auth.forgot_password', compact('title'));
    }

    public function handle_forgot_password(ForgotPasswordRequest $request)
    {
        $token = Str::random(10);
        $expiration = Carbon::now()->addHour();
        $admin = Admin::where('email', $request->email)->first();
        $admin->update([
            'token_reset_password' => $token,
            'token_duration' => $expiration,
        ]);
        ForgotPasswordJob::dispatch($request->email, $token)->delay(now()->addSecond(5));
        Session::flash('success', 'Mã xác nhận đã được gửi đến bạn. Vui lòng kiểm tra email');
        return redirect()->route('admin.form_recovery')->with([
            'email' => $request->email
        ]);
    }

    public function recovery_password()
    {
        $email = session('email');
        $title = 'Khôi phục mật khẩu';
        return view('admin.auth.recovery_password', compact('title', 'email'));
    }

    public function hanle_recovery_password(RecoveryPasswordRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $admin = Admin::where('email', $email)->first();
        if ($admin->token_reset_password === $request->token_reset_password) {
            if (Carbon::now()->greaterThan($admin->token_duration)) {
                Session::flash('error', 'Mã xác nhận đã hết hạn, vui lòng yêu cầu mã xác nhận mới');
                return redirect()->back();
            }
            $admin->update([
                'password' => Hash::make($password),
                'token_reset_password' => null,
                'token_duration' => null
            ]);
            if (auth()->guard('admin')->attempt(['email' => $email, 'password' => $password])) {
                Session::flash('success', 'Đổi mật khẩu thành công');
                return redirect()->route('admin.dashboard');
            }
        }
        Session::flash('error', 'Token không hợp lệ!');
        return redirect()->back();
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        Session::flash('success', 'Đăng xuất quản trị thành công');
        return redirect()->route('login');
    }

    public function profile()
    {
        $title = 'Thông tin cá nhân';
        return view('admin.auth.profile', compact('title'));
    }

    public function change_avatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin = Auth::guard('admin')->user();
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = time() . '_' . Str::slug($originalName) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);

            if ($admin->avatar && file_exists(public_path($admin->avatar))) {
                unlink(public_path($admin->avatar));
            }
            $admin->avatar = '/uploads/avatars/' . $filename;
            $admin->save();

            return response()->json(['success' => true, 'avatar_url' => $admin->avatar]);
        }

        return response()->json(['success' => false], 500);
    }
}
