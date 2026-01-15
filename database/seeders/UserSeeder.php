<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure roles exist (run RoleSeeder before this)
        $super = Role::where('slug', 'super-admin')->first();
        $manager = Role::where('slug', 'manager')->first();
        $editor = Role::where('slug', 'editor')->first();

        // Create 1 user per role (updateOrCreate so you can re-run seeder safely)
        if ($super) {
            User::updateOrCreate(
                ['email' => 'superuser@example.com'],
                [
                    'name' => 'Super User',
                    'password' => Hash::make('password'),
                    'role_id' => $super->id,
                    'mobile' => '03000000001',
                    'is_active' => true,
                    'last_login_at' => null,
                ]
            );
        }

        if ($manager) {
            User::updateOrCreate(
                ['email' => 'manager@example.com'],
                [
                    'name' => 'Manager User',
                    'password' => Hash::make('password'),
                    'role_id' => $manager->id,
                    'mobile' => '03000000002',
                    'is_active' => true,
                    'last_login_at' => null,
                ]
            );
        }

        if ($editor) {
            User::updateOrCreate(
                ['email' => 'editor@example.com'],
                [
                    'name' => 'Editor User',
                    'password' => Hash::make('password'),
                    'role_id' => $editor->id,
                    'mobile' => '03000000003',
                    'is_active' => true,
                    'last_login_at' => null,
                ]
            );
        }

        // Optional: create extra random users and assign random roles
        $roleIds = Role::pluck('id')->toArray();

        if (!empty($roleIds)) {
            User::factory()
                ->count(10)
                ->create()
                ->each(function (User $user) use ($roleIds) {
                    $user->update([
                        'role_id' => $roleIds[array_rand($roleIds)],
                        'is_active' => true,
                    ]);
                });
        }
    }
}
