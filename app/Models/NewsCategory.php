<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_category_news', 'category_id', 'news_id');
    }
}
