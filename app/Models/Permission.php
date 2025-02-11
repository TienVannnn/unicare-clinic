<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends SpatiePermission
{
    // public function permissionChildrent(): HasMany
    // {
    //     return $this->hasMany(Permission::class, 'parent_id');
    // }
}
