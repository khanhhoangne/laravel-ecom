<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Blog;
use App\Models\BlogDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Models\Route;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory(10)->create();
        Address::factory(10)->create();
        $this->call([PaymentTypeSeeder::class]);
        User::factory(1)->create();
        $this->call([ProductCategorySeeder::class]);
        $this->call([SupplierSeeder::class]);
        $this->call([ProductSeeder::class]);
        Product::factory(10)->create();
        $this->call([ProductOptionSeeder::class]);
        $this->call([ProductPriceSeeder::class]);
        $this->call([OrderSeeder::class]);
        $this->call([OrderDetailSeeder::class]);
        $this->call([BlogCategorySeeder::class]);
        Blog::factory(20)->create();
        BlogDetail::factory(30)->create();
        $this->call([RouteSeeder::class]);
    }
}
