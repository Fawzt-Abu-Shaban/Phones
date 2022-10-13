<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create([
            'name' => 'Super-Admin',
            'guard_name' => 'admin',
        ]);
        Role::create([
            'name' => 'HR-Admin',
            'guard_name' => 'admin',
        ]);
        Role::create([
            'name' => 'Content-Management-Admin',
            'guard_name' => 'admin',
        ]);
    }
}
