<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'staff_id',
        'morning_start',
        'morning_end',
        'afternoon_start',
        'afternoon_end',
        'slot_duration'
    ];
}
