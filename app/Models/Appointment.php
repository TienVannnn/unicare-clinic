<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'dob',
        'gender',
        'department_id',
        'doctor_id',
        'appointment_date',
        'start_time',
        'note',
        'is_viewed',
        'status',
        'cancel_token'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Admin::class, 'doctor_id');
    }

    public function appointmentReplies()
    {
        return $this->hasMany(AppointmentReply::class);
    }
}
