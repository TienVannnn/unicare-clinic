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
        'insurance',
        'total_price'
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
        return $this->belongsToMany(MedicalService::class, 'medical_certificate_service', 'medical_certificate_id', 'medical_service_id')->withPivot('service_price', 'clinic_id', 'doctor_id', 'medical_time', 'note')
            ->withTimestamps();
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($medical_certificate) {
            $date = \Carbon\Carbon::parse($medical_certificate->created_at)->format('ymd');
            $countToday = self::whereDate('created_at', $medical_certificate->created_at)->count();
            $orderPart = str_pad($countToday, 5, '0', STR_PAD_LEFT);
            $medical_certificate->medical_certificate_code = 'GK-' . $date . '-' . $orderPart;
            $medical_certificate->save();
        });
    }
}
