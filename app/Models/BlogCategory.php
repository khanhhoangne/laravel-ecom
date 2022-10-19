<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_blogs_categories';

	public function blogDetail() {
        return $this->hasMany(BlogDetail::class, 'cate_id');
    }
}
