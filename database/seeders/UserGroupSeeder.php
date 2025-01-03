<?php

namespace Database\Seeders;

use App\Models\Admin\UserGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserGroup::truncate();
        DB::table('user_groups')->insert([
            array('name' => 'Admin','assigned_modules' => '[1, 2,3,4]','status' => NULL,'is_active' => '1')
        ]);
    }
}
