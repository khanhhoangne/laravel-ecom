<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //shop_product_gallery
        DB::table('shop_product_gallery')->insert([
            'product_id' => 1,
            'image'      => 'https://techchains-ecommerce.store/storage/uploads/products/picture_1.jpg'
        ]);
        DB::table('shop_product_gallery')->insert([
            'product_id' => 1,
            'image'      => 'https://techchains-ecommerce.store/storage/uploads/products/picture_2.jpg'
        ]);
        DB::table('shop_product_gallery')->insert([
            'product_id' => 1,
            'image'      => 'https://techchains-ecommerce.store/storage/uploads/products/picture_3.jpg'
        ]);
        DB::table('shop_product_gallery')->insert([
            'product_id' => 1,
            'image'      => 'https://techchains-ecommerce.store/storage/uploads/products/picture_4.jpg'
        ]);

    }
}
