<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'acl_roles';
    protected $guarded = ['id'];

    public function roleHasPermission() {
        return $this->hasMany(RoleHasPermission::class, 'role_id');
    }

    public function userHasRoles() {
        return $this->hasMany(UserHasRole::class, 'role_id');
    }
}
