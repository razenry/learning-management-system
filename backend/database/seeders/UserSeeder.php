<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'superadmin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $guruRole = Role::where('name', 'guru')->first();
        $siswaRole = Role::where('name', 'siswa')->first();
        $waliRole = Role::where('name', 'wali')->first();

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@lms.com',
                'password' => Hash::make('password'),
                'role_id' => $superAdminRole->id,
                'phone' => '081234567890',
                'role_name' => 'superadmin'
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@lms.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'phone' => '081234567891',
                'role_name' => 'admin'
            ],
            [
                'name' => 'Guru Pengajar',
                'email' => 'guru@lms.com',
                'password' => Hash::make('password'),
                'role_id' => $guruRole->id,
                'phone' => '081234567892',
                'role_name' => 'guru'
            ],
            [
                'name' => 'Siswa Belajar',
                'email' => 'siswa@lms.com',
                'password' => Hash::make('password'),
                'role_id' => $siswaRole->id,
                'phone' => '081234567893',
                'role_name' => 'siswa'
            ],
            [
                'name' => 'Wali Murid',
                'email' => 'wali@lms.com',
                'password' => Hash::make('password'),
                'role_id' => $waliRole->id,
                'phone' => '081234567894',
                'role_name' => 'wali'
            ],
        ];

        foreach ($users as $userData) {
            $roleName = $userData['role_name'];
            unset($userData['role_name']);
            
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
            
            if (!$user->hasRole($roleName)) {
                $user->assignRole($roleName);
            }
        }
    }
}
