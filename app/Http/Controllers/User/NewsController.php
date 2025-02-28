<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function news()
    {
        $title = 'Tin tức';
        $news = News::orderByDesc('id')->get();
        return view('user.news.news', compact('title', 'news'));
    }
}
