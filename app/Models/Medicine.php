<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'unit',
        'price',
        'quantity',
    ];
    public function medicineCategories()
    {
        return $this->belongsToMany(MedicineCategory::class, 'medicine_category_medicine', 'medicine_id', 'medicine_category_id');
    }
}
