<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_name',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
