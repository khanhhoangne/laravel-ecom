<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $table = 'acl_commands';
    protected $guarded = ['id'];

    public function routes() {
        return $this->hasMany(Route::class, 'command_id');
    }

    public function roleHasPermission() {
        return $this->hasMany(RoleHasPermission::class, 'command_id');
    }
}