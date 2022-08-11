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
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // create permissions
        $permissions = [
            'permission read',
            'permission create',
            'permission edit',
            'permission delete',
            'role read',
            'role create',
            'role edit',
            'role delete',
            'user read',
            'user create',
            'user edit',
            'user delete'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
       

        $role3 = Role::create(['name' => 'super-admin']);
        //Có sẵn đủ quyền nhờ Gate::before ở AuthServiceProvider
        // create demo users
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
        ]);
        $user->assignRole($role3);


        $role2 = Role::create(['name' => 'admin']);
        foreach ($permissions as $permission) {
            $role2->givePermissionTo($permission);
        }
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole($role2);


        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('permission read');
        $role1->givePermissionTo('role read');
        $role1->givePermissionTo('user read');
        $user = User::factory()->create([
            'name' => 'Khách',
            'email' => 'test@mail.com',
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole($role1);
    }
}
