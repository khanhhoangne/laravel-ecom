<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'acl_permissions';
    protected $guarded = ['id'];

    public function routes() {
        return $this->hasMany(Route::class, 'permission_id');
    }

    public function roleHasPermission() {
        return $this->hasMany(RoleHasPermission::class, 'permission_id');
    }
}