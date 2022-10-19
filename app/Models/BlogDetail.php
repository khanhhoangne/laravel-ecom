<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogDetail extends Model
{
    use HasFactory;

    protected $table = "tbl_blogs_details";

	public function blog() {
        return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function blogCategory() {
        return $this->belongsTo(BlogCategory::class, 'cate_id');
    }
}
