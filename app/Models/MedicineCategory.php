<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'medicine_category_medicine', 'medicine_category_id', 'medicine_id');
    }
}
