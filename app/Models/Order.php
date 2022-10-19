<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'shop_orders';
    protected $guarded = ['id'];

    public function orderdetails() {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function payment()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }
}
