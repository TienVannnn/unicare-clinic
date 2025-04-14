<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'address',
        'gender',
        'clinic_id',
        'token_reset_password',
        'token_duration'
    ];

    public function roless()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function schedule()
    {
        return $this->hasOne(WorkSchedule::class, 'staff_id');
    }
}
