<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_suppliers')->insert([
            'supplier_name' => 'FPT',
            'supplier_slug' => 'fpt-trading',
            'description' => 'nhà cung cấp điện thoại, laptop',
            'status' => 'collab',
        ]);
        DB::table('shop_suppliers')->insert([
            'supplier_name' => 'Apple',
            'supplier_slug' => 'apple',
            'description' => 'nhà cung cấp điện thoại, laptop',
            'status' => 'collab',
        ]);
        DB::table('shop_suppliers')->insert([
            'supplier_name' => 'Samsung',
            'supplier_slug' => 'samsung',
            'description' => 'nhà cung cấp điện thoại, laptop',
            'status' => 'collab',
        ]);
    }
}
