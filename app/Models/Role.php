<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Role extends SpatieRole
{
    use HasUuids;

    const ROLE_ADMIN   = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_USER    = 'user';

    protected $table = 'spatie_roles';
}
