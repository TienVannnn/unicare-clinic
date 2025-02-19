<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'prescription_code',
        'note',
        'total_payment',
        'status'
    ];

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicine', 'prescription_id',  'medicine_id')->withPivot('quantity', 'dosage', 'price', 'subtotal')
            ->withTimestamps();
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Admin::class, 'doctor_id');
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
