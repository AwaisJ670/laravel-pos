<?php

namespace Database\Seeders;

use App\Models\Admin\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        DB::table('roles')->insert([
            array('name' => 'Admin','permissions' => '[1, 2,3,4,5]','status' => NULL,'is_active' => '1'),
            array('name' => 'User','permissions' => '[]','status' => NULL,'is_active' => '1'),
        ]);
    }
}
