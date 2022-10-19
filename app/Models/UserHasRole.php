<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasRole extends Model
{
    use HasFactory;

    protected $table = 'acl_user_has_role';
    protected $guarded = ['id'];

    public function userHasRole() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }
}