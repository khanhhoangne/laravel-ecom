<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_payment_types')->insert([
            'payment_name' => 'Thanh toán tiền mặt khi nhận hàng',
            'payment_slug' => 'thanh-toan-tien-mat-khi-nhan-hang',
            'description' => 'Thanh toán tiền mặt khi nhận hàng',
        ]);
        DB::table('shop_payment_types')->insert([
            'payment_name' => 'Thanh toán bằng ví MoMo',
            'payment_slug' => 'thanh-toan-bang-vi-momo',
            'description' => 'Thanh toán bằng ví MoMo',
        ]);
    }
}
