<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'admin_id',
        'appointment_id'
    ];

    public function doctor()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
