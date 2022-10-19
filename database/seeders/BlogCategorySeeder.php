<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_blogs_categories')->insert([
            'name' => 'Sản phẩm mới',
            'slug' => 'san-pham-moi',
            'status' => 1,
        ]);
        DB::table('tbl_blogs_categories')->insert([
            'name' => 'Tư vấn',
            'slug' => 'tu-van',
            'status' => 1,
        ]);
        DB::table('tbl_blogs_categories')->insert([
            'name' => 'Đánh giá',
            'slug' => 'danh-gia',
            'status' => 1,
        ]);
        DB::table('tbl_blogs_categories')->insert([
            'name' => 'Mẹo hay',
            'slug' => 'meo-hay',
            'status' => 1,
        ]);
        DB::table('tbl_blogs_categories')->insert([
            'name' => 'Mới nhất',
            'slug' => 'moi-nhat',
            'status' => 1,
        ]);
    }
}
