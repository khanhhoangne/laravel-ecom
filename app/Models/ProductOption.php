<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;

    protected $table = 'shop_product_option';
    protected $guarded = ['id'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
