<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'department_id',
        'title',
        'question',
        'is_viewed',
        'status',
        'doctor_id',
        'answer',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Admin::class, 'doctor_id');
    }
}
