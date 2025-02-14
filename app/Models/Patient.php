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
            $patient->patient_code = 'BN' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
            $patient->save();
        });
    }
}
