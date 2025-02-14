<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'clinic_code'
    ];
    protected static function boot()
    {
        parent::boot();
        static::created(function ($clinic) {
            $clinic->clinic_code = 'PK' . str_pad($clinic->id, 3, '0', STR_PAD_LEFT);
            $clinic->save();
        });
    }
}
