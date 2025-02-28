<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;

class HomeController extends Controller
{
    public function home()
    {
        $title = 'Trang chủ';
        $news = News::orderByDesc('id')->get();
        return view('user.home.home', compact('title', 'news'));
    }
}
