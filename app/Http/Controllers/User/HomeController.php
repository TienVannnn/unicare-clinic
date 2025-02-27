<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\EditAccountRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function home()
    {
        $title = 'Trang chủ';
        return view('user.home.home', compact('title'));
    }

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
}
