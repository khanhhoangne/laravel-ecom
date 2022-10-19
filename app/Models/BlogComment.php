<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "tbl_blogs_comments";

    protected $guarded = ['id'];
}
