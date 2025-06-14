<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalService extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'medical_service_code',
        'description',
        'price',
        'insurance_price',
        'status'
    ];
    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'clinic_medical_service', 'medical_service_id', 'clinic_id');
    }
    public function medical_certificates()
    {
        return $this->belongsToMany(MedicalCertificate::class, 'medical_certificate_service', 'medical_service_id ', 'medical_certificate_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::created(function ($medical_service) {
            $medical_service->medical_service_code = 'DV' . str_pad($medical_service->id, 3, '0', STR_PAD_LEFT);
            $medical_service->save();
        });
    }
}
