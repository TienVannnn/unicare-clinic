<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionMedicine extends Model
{
    use HasFactory;
    protected $table = 'prescription_medicine';
    protected $fillable = [
        'prescription_id',
        'medicine_id',
        'quantity',
        'price',
        'subtotal',
        'dosage',
        'medicine_batch_id'
    ];
}
