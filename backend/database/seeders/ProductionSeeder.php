<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Core Data
        $this->call([
            RoleSeeder::class,
            AcademicLevelSeeder::class,
            ProductSeeder::class,
        ]);

        // 2. Initial Super Admin
        $superAdminRole = Role::where('name', 'superadmin')->first();

        $admin = User::updateOrCreate(
            ['email' => 'superadmin@lms.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role_id' => $superAdminRole->id,
                'phone' => '081111111111',
            ]
        );

        if (!$admin->hasRole('superadmin')) {
            $admin->assignRole('superadmin');
        }

        $this->command->info('Production data seeded successfully!');
        $this->command->info('SuperAdmin Login: superadmin@lms.com / password');
    }
}
