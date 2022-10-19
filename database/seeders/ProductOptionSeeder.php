<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOptionSeeder extends Seeder
{
    public function run()
    {
        DB::table('shop_product_option')->insert([
            'product_id' => 1,
            'option' => 'Bộ nhớ trong',
            'detail' => '128GB'
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 1,
            'option' => 'Bộ nhớ trong',
            'detail' => '256GB'
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 1,
            'option' => 'Bộ nhớ trong',
            'detail' => '512GB',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 1,
            'option' => 'Bộ nhớ trong',
            'detail' => '1T',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 1,
            'option' => 'Màu sắc',
            'detail' => 'Vàng đồng',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 1,
            'option' => 'Màu sắc',
            'detail' => 'Bạc',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 1,
            'option' => 'Màu sắc',
            'detail' => 'Xám',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 1,
            'option' => 'Màu sắc',
            'detail' => 'Xanh lá',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 1,
            'option' => 'Màu sắc',
            'detail' => 'Xanh dương',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 2,
            'option' => 'RAM/Bộ nhớ trong',
            'detail' => '8GB/128GB'
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 2,
            'option' => 'RAM/Bộ nhớ trong',
            'detail' => '12GB/256GB'
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 2,
            'option' => 'RAM/Bộ nhớ trong',
            'detail' => '12/512GB',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 2,
            'option' => 'Màu sắc',
            'detail' => 'Đỏ',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 2,
            'option' => 'Màu sắc',
            'detail' => 'Trắng',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 2,
            'option' => 'Màu sắc',
            'detail' => 'Đen',
        ]);
        DB::table('shop_product_option')->insert([
            'product_id' => 2,
            'option' => 'Màu sắc',
            'detail' => 'Xanh lá',
        ]);
    }
}
