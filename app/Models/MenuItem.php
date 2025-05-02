<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'url',
        'order'
    ];
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }
}
