<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    public function run()
    {
        DB::table('shop_order_details')->insert([
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'unit_price' => 33990000,
            'product_option' => '2,5',
            'discount_amount' => 3600000,
        ]);
        DB::table('shop_order_details')->insert([
            'order_id' => 1,
            'product_id' => 2,
            'quantity' => 2,
            'unit_price' => 27990000,
            'product_option' => '10,16',
            'discount_amount' => 4000000,
        ]);
        DB::table('shop_order_details')->insert([
            'order_id' => 2,
            'product_id' => 2,
            'quantity' => 1,
            'unit_price' => 33990000,
            'product_option' => '12,15',
            'discount_amount' => 3000000,
        ]);
        DB::table('shop_order_details')->insert([
            'order_id' => 3,
            'product_id' => 1,
            'quantity' => 1,
            'unit_price' => 36790000,
            'product_option' => '3,6',
            'discount_amount' => 3300000,
        ]);
    }
}
