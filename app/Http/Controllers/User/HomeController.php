<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function home()
    {
        $title = 'Trang chủ';
        return view('user.home.home', compact('title'));
    }

    public function login_page()
    {
        $title = 'Đăng nhập';
        return view('user.auth.login', compact('title'));
    }

    public function register_page()
    {
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

    public function profile()
    {
        if (!auth()->check()) return redirect()->route('user.login');
        $title = 'Thông tin tài khoản';
        $auth = auth()->user();
        return view('user.auth.profile', compact('title', 'auth'));
    }
}
