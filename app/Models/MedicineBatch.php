<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineBatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'medicine_id',
        'batch_number',
        'manufacturer',
        'production_address',
        'manufacture_date',
        'expiry_date',
        'quantity_received',
        'purchase_price',
        'total_quantity',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($medicine_batch) {
            $medicine_batch->batch_number = 'LT' . str_pad($medicine_batch->id, 5, '0', STR_PAD_LEFT);
            $medicine_batch->save();
        });
    }
}
