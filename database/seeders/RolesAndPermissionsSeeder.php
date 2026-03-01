<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        Permissions
         */
        $permissions = [

            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'users.assign_role',

            // Categories
            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',

            // Products
            'products.view',
            'products.create',
            'products.update',
            'products.delete',
            'products.toggle_status',

            // Variants
            'variants.view',
            'variants.create',
            'variants.update',
            'variants.delete',

            // Orders
            'orders.view',
            'orders.create',
            'orders.update_status',
            'orders.delete',

            // Cart
            'cart.view',
            'cart.add_product',
            'cart.update_product',
            'cart.remove_product',

            // Wishlist
            'wishlist.view',
            'wishlist.add',
            'wishlist.remove',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        
        
        //  Roles
        
        

        // Admin
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // Employee
        $employee = Role::firstOrCreate(['name' => 'employee']);
        $employee->givePermissionTo([
            'dashboard.view',

            'products.view',
            'products.create',
            'products.update',

            'categories.view',
            'categories.create',
            'categories.update',

            'variants.view',
            'variants.create',
            'variants.update',

            'orders.view',
            'orders.update_status',
        ]);

        // User
        $user = Role::firstOrCreate(['name' => 'user']);
        $user->givePermissionTo([
            'products.view',
            'categories.view',

            'cart.view',
            'cart.add_product',
            'cart.update_product',
            'cart.remove_product',

            'wishlist.view',
            'wishlist.add',
            'wishlist.remove',

            'orders.create',
            'orders.view',
        ]);
    }
};

