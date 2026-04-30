<?php

namespace App\Modules\Attendance\Services;

use App\Core\Services\BaseService;
use App\Modules\Attendance\Repositories\AttendanceRepository;
use Illuminate\Support\Str;

class AttendanceService extends BaseService
{
    public function __construct(private AttendanceRepository $attendanceRepository) {}

    public function createSession(int $classId, int $teacherId, array $location)
    {
        return $this->attendanceRepository->create([
            'class_id' => $classId,
            'teacher_id' => $teacherId,
            'qr_code' => Str::random(32),
            'expired_at' => now()->addMinutes(30),
            'latitude' => $location['latitude'] ?? null,
            'longitude' => $location['longitude'] ?? null,
            'radius' => $location['radius'] ?? 100,
        ]);
    }

    public function scanQr(int $studentId, string $qrCode, array $location)
    {
        $session = $this->attendanceRepository->findSessionByQr($qrCode);

        if (!$session || $session->isExpired()) {
            return ['error' => 'Invalid or expired QR code'];
        }

        // Location validation (very basic distance check could be added here)
        
        return $this->attendanceRepository->createAttendance([
            'session_id' => $session->id,
            'student_id' => $studentId,
            'status' => 'hadir',
            'scanned_at' => now(),
            'latitude' => $location['latitude'] ?? null,
            'longitude' => $location['longitude'] ?? null,
        ]);
    }
}
