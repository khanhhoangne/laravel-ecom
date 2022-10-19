<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('shop_categories')->insert([
            'category_name' => 'Điện thoại',
            'category_slug' => 'dien-thoai',
            'description' => 'Điện thoại',
            'status' => 'display',
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Laptop',
            'category_slug' => 'laptop',
            'description' => 'Laptop',
            'status' => 'display',
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Tablet',
            'category_slug' => 'tablet',
            'description' => 'Tablet',
            'status' => 'display',
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Đồng hồ',
            'category_slug' => 'dong-ho',
            'description' => 'Đồng hồ',
            'status' => 'display',
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Loa',
            'category_slug' => 'loa',
            'description' => 'loa',
            'status' => 'display',
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Iphpne',
            'category_slug' => 'iphone',
            'description' => 'Điện thoại Iphone',
            'status' => 'display',
            'parent_id' => 1
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Samsung',
            'category_slug' => 'samsung',
            'description' => 'Điện thoại Samsung',
            'status' => 'display',
            'parent_id' => 1
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Oppo',
            'category_slug' => 'oppo',
            'description' => 'Điện thoại Oppo',
            'status' => 'display',
            'parent_id' => 1
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Xiaomi',
            'category_slug' => 'xiaomi',
            'description' => 'Điện thoại Xiaomi',
            'status' => 'display',
            'parent_id' => 1
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Macbook',
            'category_slug' => 'macbook',
            'description' => 'Laptop Macbook',
            'status' => 'display',
            'parent_id' => 2
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Asus',
            'category_slug' => 'asus',
            'description' => 'Laptop Asus',
            'status' => 'display',
            'parent_id' => 2
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'HP',
            'category_slug' => 'hp',
            'description' => 'Laptop hp',
            'status' => 'display',
            'parent_id' => 2
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'DELL',
            'category_slug' => 'dell',
            'description' => 'Laptop DELL',
            'status' => 'display',
            'parent_id' => 2
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'MSI',
            'category_slug' => 'msi',
            'description' => 'Laptop MSI',
            'status' => 'display',
            'parent_id' => 2
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Ipad',
            'category_slug' => 'ipad',
            'description' => 'tablet Ipad',
            'status' => 'display',
            'parent_id' => 3
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Samsung',
            'category_slug' => 'tablet-samsung',
            'description' => 'tablet Samsung',
            'status' => 'display',
            'parent_id' => 3
        ]);
        DB::table('shop_categories')->insert([
            'category_name' => 'Xiaomi',
            'category_slug' => 'tablet-xiaomi',
            'description' => 'tablet Xiaomi',
            'status' => 'display',
            'parent_id' => 3
        ]);
    }
}
