<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_products')->insert([
            'product_code' => 'IPHONE13PRO128',
            'product_name' => 'Điện thoại iPhone 13 Pro Max 128GB',
            'product_slug' => 'dien-thoai-iphone-13-pro-max-128gb',
            'image' => 'https://cdn.tgdd.vn/Products/Images/42/230529/iphone-13-pro-max-gold-1-600x600.jpg',
            'is_continued' => 'Continued',
            'category_id' => 6,
            'supplier_id' => 2,
        ]);
        DB::table('shop_products')->insert([
            'product_code' => 'SAMULTRA128',
            'product_name' => 'Điện thoại Samsung Galaxy S22 Ultra 5G 128GB',
            'product_slug' => 'dien-thoai-samsung-galaxy-s22-ultra-5G-128gb',
            'image' => 'https://cdn.tgdd.vn/Products/Images/42/235838/Galaxy-S22-Ultra-Burgundy-600x600.jpg',
            'is_continued' => 'Continued',
            'category_id' => 6,
            'supplier_id' => 1,
        ]);
        DB::table('shop_products')->insert([
            'product_code' => 'XIAOREDMI11',
            'product_name' => 'Điện thoại Xiaomi Redmi Note 11 Pro',
            'product_slug' => 'dien-thoai-xiaomi-redmi-note-11-pro',
            'image' => 'https://cdn.tgdd.vn/Products/Images/42/251856/samsung-galaxy-a03-xanh-thumb-600x600.jpg',
            'is_continued' => 'Continued',
            'category_id' => 6,
            'supplier_id' => 1,
        ]);
    }
}
