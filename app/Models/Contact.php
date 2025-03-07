<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'title',
        'message',
        'status'
    ];

    public function contactReplies()
    {
        return $this->hasMany(ContactReply::class);
    }
}
