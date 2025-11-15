<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'fill attendance']);
        Permission::create(['name' => 'edit attendance']);
        Permission::create(['name' => 'discard attendance']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo('fill attendance');
        $admin->givePermissionTo('edit attendance');
        $admin->givePermissionTo('discard attendance');

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo('fill attendance');

        $employee = Role::create(['name' => 'employee']);
        $employee->givePermissionTo('fill attendance');
    }
}
