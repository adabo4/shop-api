<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'products.create',
            'products.update',
            'products.delete',
            'categories.create',
            'categories.update',
            'categories.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $admin = Role::findByName('admin', 'web');

        $admin->syncPermissions($permissions);

        $productManager = Role::findByName('product-manager', 'web');

        $productManager->syncPermissions([
            'products.create',
            'products.update',
            'products.delete',
        ]);


        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
