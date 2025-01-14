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
            ['role_id' => 1, 'access_key' => md5('admin.password'), 'first_name' => 'Super', 'last_name' => 'Admin', 'email' =>'admin@test.com' , 'password' => bcrypt('password')],
            ['role_id' => 2, 'access_key' => md5('user.password'), 'first_name' => 'User', 'last_name' => '', 'email' =>'user@test.com' , 'password' => bcrypt('password')],
        ]);
    }
}
