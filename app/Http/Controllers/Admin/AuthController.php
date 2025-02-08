<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
}
