<?php

namespace Database\Seeders;

use App\Models\Admin\Modules;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modules::truncate();
        DB::table('modules')->insert([
            array('parent_id' => '0', 'name' => 'Dashboard', 'route' => '/admin/dashboard', 'head_name' => NULL, 'icon' => 'fas fa-tasks', 'order' => NULL, 'is_active' => '1'),
            array('parent_id' => '0', 'name' => 'Management', 'route' => '', 'head_name' => NULL, 'icon' => 'fas fa-tasks', 'order' => NULL, 'is_active' => '1'),
            array('parent_id' => '2', 'name' => 'Users', 'route' => '/admin/users', 'head_name' => NULL, 'icon' => NULL, 'order' => NULL, 'is_active' => '1'),
            array('parent_id' => '2', 'name' => 'Roles', 'route' => '/admin/roles', 'head_name' => NULL, 'icon' => NULL, 'order' => NULL, 'is_active' => '1'),
            array('parent_id' => '0', 'name' => 'Categories', 'route' => '/admin/categories', 'head_name' => NULL, 'icon' => 'fas fa-tasks', 'order' => NULL, 'is_active' => '1'),
            array('parent_id' => '0', 'name' => 'Products', 'route' => '/admin/products', 'head_name' => NULL, 'icon' => 'fas fa-tasks', 'order' => NULL, 'is_active' => '1'),
            

        ]);
    }
}
