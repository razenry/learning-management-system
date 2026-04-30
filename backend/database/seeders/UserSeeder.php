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

        // Superadmin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@lms.com',
            'password' => Hash::make('password'),
            'role_id' => $superAdminRole->id,
            'phone' => '081234567890'
        ]);
        $superAdmin->assignRole('superadmin');

        // Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'phone' => '081234567891'
        ]);
        $admin->assignRole('admin');

        // Guru
        $guru = User::create([
            'name' => 'Guru Pengajar',
            'email' => 'guru@lms.com',
            'password' => Hash::make('password'),
            'role_id' => $guruRole->id,
            'phone' => '081234567892'
        ]);
        $guru->assignRole('guru');

        // Siswa
        $siswa = User::create([
            'name' => 'Siswa Belajar',
            'email' => 'siswa@lms.com',
            'password' => Hash::make('password'),
            'role_id' => $siswaRole->id,
            'phone' => '081234567893'
        ]);
        $siswa->assignRole('siswa');

        // Wali
        $wali = User::create([
            'name' => 'Wali Murid',
            'email' => 'wali@lms.com',
            'password' => Hash::make('password'),
            'role_id' => $waliRole->id,
            'phone' => '081234567894'
        ]);
        $wali->assignRole('wali');
    }
}
