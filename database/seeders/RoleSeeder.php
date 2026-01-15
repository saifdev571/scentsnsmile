<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $allPermissions = [
            'dashboard.view',
            'products.view','products.create','products.edit','products.delete',
            'categories.view','categories.create','categories.edit','categories.delete',
            'colors.view','colors.create','colors.edit','colors.delete',
            'sizes.view','sizes.create','sizes.edit','sizes.delete',
            'brands.view','brands.create','brands.edit','brands.delete',
            'collections.view','collections.create','collections.edit','collections.delete',
            'tags.view','tags.create','tags.edit','tags.delete',
            'coupons.view','coupons.create','coupons.edit','coupons.delete',
            'orders.view','orders.edit','orders.delete',
            'customers.view','customers.edit','customers.delete',
            'admins.view','admins.create','admins.edit','admins.delete',
            'roles.view','roles.create','roles.edit','roles.delete',
            'settings.view','settings.edit',
            'logs.view'
        ];

        Role::updateOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'Super Admin',
                'permissions' => $allPermissions,
                'description' => 'Full system access with all permissions'
            ]
        );

        Role::updateOrCreate(
            ['slug' => 'manager'],
            [
                'name' => 'Manager',
                'permissions' => [
                    'dashboard.view',
                    'products.view','products.create','products.edit','products.delete',
                    'categories.view','categories.create','categories.edit','categories.delete',
                    'colors.view','colors.create','colors.edit','colors.delete',
                    'sizes.view','sizes.create','sizes.edit','sizes.delete',
                    'brands.view','brands.create','brands.edit','brands.delete',
                    'collections.view','collections.create','collections.edit','collections.delete',
                    'tags.view','tags.create','tags.edit','tags.delete',
                    'coupons.view','coupons.create','coupons.edit','coupons.delete',
                    'orders.view','orders.edit',
                    'customers.view'
                ],
                'description' => 'Can manage products, orders, and customers'
            ]
        );

        Role::updateOrCreate(
            ['slug' => 'editor'],
            [
                'name' => 'Editor',
                'permissions' => [
                    'dashboard.view',
                    'products.view','products.edit',
                    'categories.view',
                    'colors.view',
                    'sizes.view',
                    'brands.view',
                    'collections.view',
                    'tags.view',
                    'coupons.view',
                    'orders.view',
                    'customers.view'
                ],
                'description' => 'Can view and edit existing content only'
            ]
        );
    }
}
