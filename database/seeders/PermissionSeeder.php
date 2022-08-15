<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use \App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions

        Permission::insert([
            ['name' => 'permission read'],
            ['name' => 'permission create'],
            ['name' => 'permission edit'],
            ['name' => 'permission delete'],
            ['name' => 'role read'],
            ['name' => 'role create'],
            ['name' => 'role edit'],
            ['name' => 'role delete'],
            ['name' => 'user read'],
            ['name' => 'user create'],
            ['name' => 'user edit'],
            ['name' => 'user delete'],
        ]);
    }
}
