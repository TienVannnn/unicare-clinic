<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_code',
        'name',
        'dob',
        'gender',
        'phone',
        'address',
        'cccd',
        'bhyt_number',
        'hospital_registered',
        'bhyt_expired_date'
    ];
    protected static function boot()
    {
        parent::boot();

        static::created(function ($patient) {
            $date = \Carbon\Carbon::parse($patient->created_at);
            $datePart = $date->format('ymd');
            $countToday = self::whereDate('created_at', $date->toDateString())->count();
            $orderPart = str_pad($countToday, 5, '0', STR_PAD_LEFT);
            $patient->patient_code = '189' . $datePart . $orderPart;
            $patient->save();
        });
    }


    public function medical_certificates()
    {
        return $this->hasMany(MedicalCertificate::class, 'patient_id');
    }
}
