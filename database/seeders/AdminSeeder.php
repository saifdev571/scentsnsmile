<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure RoleSeeder already ran
        $superRoleId = Role::where('slug', 'super-admin')->value('id');

        Admin::updateOrCreate(
            ['email' => 'super@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => 'Admin@12345',   // ✅ auto-hash (because Admin model has 'password' => 'hashed' cast)
                'phone' => '03000000000',
                'avatar' => null,
                'role_id' => $superRoleId,
                'status' => 'active',
                'is_active' => true,
                'last_login_at' => null,
            ]
        );
    }
}
