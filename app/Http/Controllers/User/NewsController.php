<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function news($slugCategory)
    {
        $category = NewsCategory::where('slug', $slugCategory)->where('status', 1)->firstOrFail();
        $news = $category->news()->where('status', 1)->paginate(12);
        $title = $category->name;
        return view('user.news.news', compact('title', 'news', 'category'));
    }

    public function news_detail($slugCategory, $slug)
    {
        $category = NewsCategory::where('slug', $slugCategory)->where('status', 1)->firstOrFail();
        $blog = News::where('slug', $slug)
            ->whereHas('newsCategories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
                $query->where('status', 1);
            })->firstOrFail();

        $title = $blog->title;
        $categories = NewsCategory::orderByDesc('id')->where('status', 1)->get();
        $relatedNews = News::whereHas('newsCategories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
            $query->where('status', 1);
        })
            ->where('id', '!=', $blog->id)
            ->orderByDesc('id')
            ->take(4)
            ->get();
        return view('user.news.news_single', compact('title', 'blog', 'categories', 'relatedNews', 'category'));
    }
}
