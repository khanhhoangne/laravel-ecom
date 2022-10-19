<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::table('shop_orders')->insert([
            'employee_id' => 1,
            'customer_id' => 1,
            'order_date' => '2022-05-22',
            'order_note' => "giao giờ hành chính",
            'address_id' => 1,
            'shipping_fee' => 25000,
            'payment_type_id' => 1,
            'order_status' => 4,
            'created_at' => '2022-05-22 03:14:07.999999',
            'updated_at' => '2022-05-22 03:14:07.999999',
        ]);
        DB::table('shop_orders')->insert([
            'employee_id' => 1,
            'customer_id' => 2,
            'order_date' => '2022-05-24',
            'order_note' => "giao giờ hành chính",
            'address_id' => 3,
            'shipping_fee' => 15000,
            'payment_type_id' => 2,
            'order_status' => 1,
            'created_at' => '2022-05-24 04:10:05.000000',
            'updated_at' => '2022-05-24 04:10:05.000000',
        ]);
        DB::table('shop_orders')->insert([
            'employee_id' => 1,
            'customer_id' => 3,
            'order_date' => '2022-05-25',
            'order_note' => "giao giờ hành chính",
            'address_id' => 2,
            'shipping_fee' => 30000,
            'payment_type_id' => 1,
            'order_status' => 2,
            'created_at' => '2022-05-25 08:25:07.888888',
            'updated_at' => '2022-05-25 08:25:07.888888',
        ]);
    }
}
