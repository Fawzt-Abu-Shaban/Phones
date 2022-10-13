<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //====================== ADMIN Permission ===============================//
        // Permission::create(['name' => 'Create-' , 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read-' , 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-' , 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Admin', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Role', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Permission', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Permission', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Permission', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Category', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Category', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Category', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Type', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Type', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Type', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Product', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Product', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Product', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-User', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-User', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-User', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Slider', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Slider', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Slider', 'guard_name' => 'admin']);


        // Permission::create(['name' => 'Create-Order', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Orders', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Order', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-Order', 'guard_name' => 'admin']);



        //====================== USER Permission ===============================//
        // Permission::create(['name' => 'Create-', 'guard_name' => 'user']);
        // Permission::create(['name' => 'Read-', 'guard_name' => 'user']);
        // Permission::create(['name' => 'Update-', 'guard_name' => 'user']);
        // Permission::create(['name' => 'Delete-', 'guard_name' => 'user']);

        // Permission::create(['name' => 'Read-Categories', 'guard_name' => 'user']);
        // Permission::create(['name' => 'Read-Types', 'guard_name' => 'user']);
        // Permission::create(['name' => 'Read-Products', 'guard_name' => 'user']);
    }
}
