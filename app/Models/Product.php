<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'shop_products';
    protected $fillable = [
        'id', 'product_code', 'product_name', 'product_slug', 'image', 'short_description', 'description', 'is_continued', 'is_featured', 'is_new', 'category_id', 'supplier_id'
    ];
    protected $guarded = ['id'];

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function supplier() {
        return $this->belongsTo(ProductSupplier::class, 'supplier_id');
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function productOptions() {
        return $this->hasMany(ProductOption::class, 'product_id');
    }

    public function productPrices() {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    public function productGallery() {
        return $this->hasMany(ProductGallery::class, 'product_id');
    }
}
