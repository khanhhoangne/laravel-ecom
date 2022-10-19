<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    use HasFactory;

    protected $table = 'acl_role_has_permissions';
    protected $guarded = ['id'];

    public function command() {
        return $this->belongsTo(Command::class, 'command_id');
    }

    public function permission() {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }
}