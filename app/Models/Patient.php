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
        'address'
    ];
    protected static function boot()
    {
        parent::boot();
        static::created(function ($patient) {
            $randomNumber = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            $patient->patient_code = 'BN' . $randomNumber;
            $patient->save();
        });
    }

    public function medical_certificates()
    {
        return $this->hasMany(MedicalCertificate::class, 'patient_id');
    }
}
