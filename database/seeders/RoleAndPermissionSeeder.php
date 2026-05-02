<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'view records']);
        Permission::create(['name' => 'create records']);
        Permission::create(['name' => 'edit records']);
        Permission::create(['name' => 'delete records']);
        Permission::create(['name' => 'manage users']);

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $secretary = Role::create(['name' => 'secretary']);
        $secretary->givePermissionTo(['view records', 'create records', 'edit records']);

        $committee = Role::create(['name' => 'committee']);
        $committee->givePermissionTo(['view records']);
    }
}