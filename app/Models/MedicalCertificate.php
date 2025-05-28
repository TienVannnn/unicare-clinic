<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalCertificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'medical_certificate_code',
        'patient_id',
        'medical_status',
        'payment_status',
        'doctor_id',
        'clinic_id',
        'symptom',
        'diagnosis',
        'conclude',
        'result_file',
        'medical_time',
        'discharge_date',
        're_examination_date',
        'insurance'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Admin::class, 'doctor_id');
    }
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    public function services()
    {
        return $this->belongsToMany(MedicalService::class, 'medical_certificate_service', 'medical_certificate_id', 'medical_service_id')->withPivot('clinic_id', 'doctor_id', 'medical_time', 'note')
            ->withTimestamps();
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($medical_certificate) {
            $medical_certificate->medical_certificate_code = 'GK' . str_pad($medical_certificate->id, 8, '0', STR_PAD_LEFT);
            $medical_certificate->save();
        });
    }
}
