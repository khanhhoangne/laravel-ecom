<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('acl_routes')->insert([
            'route' => '/customers',
            'command_id' => 1,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/categories',
            'command_id' => 2,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/categories/add',
            'command_id' => 2,
            'permission_id' => 2,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/categories/edit',
            'command_id' => 2,
            'permission_id' => 5,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/suppliers',
            'command_id' => 3,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/suppliers/add',
            'command_id' => 3,
            'permission_id' => 2,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/suppliers/edit',
            'command_id' => 3,
            'permission_id' => 5,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/products',
            'command_id' => 4,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/orders',
            'command_id' => 5,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/payments',
            'command_id' => 6,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/payments/add',
            'command_id' => 6,
            'permission_id' => 2,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/payments/edit',
            'command_id' => 6,
            'permission_id' => 5,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/blogcategories',
            'command_id' => 7,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/blogcategories/add',
            'command_id' => 7,
            'permission_id' => 2,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/blogcategories/edit',
            'command_id' => 7,
            'permission_id' => 5,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/administrators',
            'command_id' => 8,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/administrators/add',
            'command_id' => 8,
            'permission_id' => 2,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/administrators/edit',
            'command_id' => 8,
            'permission_id' => 5,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/roles',
            'command_id' => 9,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/roles/add',
            'command_id' => 9,
            'permission_id' => 2,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/roles/edit',
            'command_id' => 9,
            'permission_id' => 5,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/commands',
            'command_id' => 9,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/permissions',
            'command_id' => 9,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/grant-permissions',
            'command_id' => 9,
            'permission_id' => 1,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/grant-permissions/add',
            'command_id' => 9,
            'permission_id' => 2,
        ]);
        DB::table('acl_routes')->insert([
            'route' => '/grant-permissions/edit',
            'command_id' => 9,
            'permission_id' => 5,
        ]);
    }
}
