<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AcademicLevel;
use App\Modules\Products\Models\Product;
use App\Modules\Classes\Models\ClassRoom;
use App\Modules\Classes\Models\Enrollment;
use App\Modules\Attendance\Models\AttendanceSession;
use App\Modules\Attendance\Models\Attendance;
use App\Modules\Hafiz\Models\HafizProgress;
use App\Modules\Users\Models\WaliRelation;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DevDummySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Ensure Roles and Basics exist
        $this->call([
            RoleSeeder::class,
            AcademicLevelSeeder::class,
            ProductSeeder::class,
        ]);

        $guruRole = Role::where('name', 'guru')->first();
        $siswaRole = Role::where('name', 'siswa')->first();
        $waliRole = Role::where('name', 'wali')->first();
        $superAdminRole = Role::where('name', 'superadmin')->first();

        // 1.5 Create SuperAdmin
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@lms.com',
            'password' => Hash::make('password'),
            'role_id' => $superAdminRole->id,
            'phone' => '081111111111',
        ]);
        $admin->assignRole('superadmin');

        // 2. Create Teachers (Guru)
        $gurus = [];
        for ($i = 1; $i <= 5; $i++) {
            $guru = User::create([
                'name' => 'Guru ' . $faker->name,
                'email' => "guru$i@lms.com",
                'password' => Hash::make('password'),
                'role_id' => $guruRole->id,
                'phone' => '082' . $faker->numerify('#########'),
            ]);
            $guru->assignRole('guru');
            $gurus[] = $guru;
        }

        // 3. Create Classrooms
        $products = Product::all();
        $classes = [];
        foreach ($products as $product) {
            for ($j = 1; $j <= 2; $j++) {
                $classes[] = ClassRoom::create([
                    'name' => $product->name . " - Group " . chr(64 + $j),
                    'product_id' => $product->id,
                    'teacher_id' => $gurus[array_rand($gurus)]->id,
                    'description' => 'Dummy class for ' . $product->name,
                ]);
            }
        }

        // 4. Create Students (Siswa) and Parents (Wali)
        $students = [];
        for ($k = 1; $k <= 20; $k++) {
            // Create Student
            $student = User::create([
                'name' => 'Siswa ' . $faker->name,
                'email' => "siswa$k@lms.com",
                'password' => Hash::make('password'),
                'role_id' => $siswaRole->id,
                'phone' => '085' . $faker->numerify('#########'),
            ]);
            $student->assignRole('siswa');
            $students[] = $student;

            // Enroll Student to a random class
            $class = $classes[array_rand($classes)];
            Enrollment::create([
                'user_id' => $student->id,
                'class_id' => $class->id,
            ]);

            // Create Parent (every 2 students share a parent for realism)
            if ($k % 2 == 1) {
                $parent = User::create([
                    'name' => 'Wali ' . $faker->name,
                    'email' => "wali" . (intval($k/2)+1) . "@lms.com",
                    'password' => Hash::make('password'),
                    'role_id' => $waliRole->id,
                    'phone' => '087' . $faker->numerify('#########'),
                ]);
                $parent->assignRole('wali');
            }

            WaliRelation::create([
                'student_id' => $student->id,
                'wali_id' => $parent->id,
            ]);

            // 5. Generate Hafiz Progress
            for ($m = 1; $m <= 5; $m++) {
                HafizProgress::create([
                    'student_id' => $student->id,
                    'juz' => rand(1, 30),
                    'ayat_start' => $m * 5,
                    'ayat_end' => ($m * 5) + 4,
                    'status' => $faker->randomElement(['hafalan', 'murojaah']),
                    'date' => now()->subDays(rand(0, 30)),
                ]);
            }

            // 6. Generate Dummy Payments
            Payment::create([
                'user_id' => $student->id,
                'amount' => 500000,
                'status' => $faker->randomElement(['pending', 'completed', 'failed']),
                'paid_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        // 7. Generate Attendance Records for the last 7 days
        foreach ($classes as $class) {
            for ($d = 0; $d < 7; $d++) {
                $date = Carbon::now()->subDays($d);
                if ($date->isWeekend()) continue;

                $session = AttendanceSession::create([
                    'class_id' => $class->id,
                    'teacher_id' => $class->teacher_id,
                    'qr_code' => 'QR-' . strtoupper($faker->bothify('??###??')),
                    'expired_at' => $date->copy()->setTime(23, 59, 59),
                    'latitude' => -6.200000,
                    'longitude' => 106.816666,
                    'radius' => 100,
                ]);

                $enrollments = Enrollment::where('class_id', $class->id)->get();
                foreach ($enrollments as $enrollment) {
                    Attendance::create([
                        'session_id' => $session->id,
                        'student_id' => $enrollment->user_id,
                        'status' => $faker->randomElement(['hadir', 'hadir', 'hadir', 'izin', 'alfa']),
                        'scanned_at' => $date->copy()->setTime(rand(7, 8), rand(0, 59)),
                    ]);
                }
            }
        }

        $this->command->info('Development dummy data seeded successfully!');
    }
}
