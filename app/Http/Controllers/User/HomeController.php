<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $title = 'Trang chủ';
        return view('user.home.home', compact('title'));
    }
}
