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
            [
                'name' => 'permission read',
                'guard_name' => 'web'
            ],
            [
                'name' => 'role read',
                'guard_name' => 'web'
            ],
            [
                'name' => 'role create',
                'guard_name' => 'web'
            ],
            [
                'name' => 'role edit',
                'guard_name' => 'web'
            ],
            [
                'name' => 'role delete',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user read',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user create',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user edit',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user delete',
                'guard_name' => 'web'
            ],
            [
                'name' => 'articles publish',
                'guard_name' => 'web'
            ],
        ]);
    }
}
