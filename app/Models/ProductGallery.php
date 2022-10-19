<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    use HasFactory;

    protected $table = 'shop_product_gallery';
    protected $guarded = ['id'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
