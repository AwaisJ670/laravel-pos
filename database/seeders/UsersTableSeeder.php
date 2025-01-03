<?php

namespace Database\Seeders;

use App\Models\Admin\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('users')->insert([
            ['parent_id' => 0,'role_id' => 1, 'access_key' => md5('admin.password'), 'first_name' => 'Admin', 'last_name' => '', 'email' =>'admin@test.com' , 'password' => bcrypt('password')],
        ]);
    }
}
