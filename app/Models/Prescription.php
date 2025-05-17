<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'medical_certificate_id',
        'prescription_code',
        'note',
        'total_payment',
        'status'
    ];

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicine', 'prescription_id',  'medicine_id')->withPivot('quantity', 'dosage', 'price', 'subtotal', 'medicine_batch_id')
            ->withTimestamps();
    }

    public function doctor()
    {
        return $this->belongsTo(Admin::class, 'doctor_id');
    }

    public function medical_certificate()
    {
        return $this->belongsTo(MedicalCertificate::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($prescription) {
            $prescription->prescription_code = 'DT' . str_pad($prescription->id, 5, '0', STR_PAD_LEFT);
            $prescription->save();
        });
    }
}
