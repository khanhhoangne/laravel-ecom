<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSupplier extends Model
{
    use HasFactory;
    
    protected $table = 'shop_suppliers';

    public function products() {
        return $this->hasMany(Product::class, 'supplier_id');
    }
}
