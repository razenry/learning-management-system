<?php

namespace App\Modules\Attendance\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Modules\Attendance\Models\AttendanceSession;
use App\Modules\Attendance\Models\Attendance;

class AttendanceRepository extends BaseRepository
{
    public function __construct(AttendanceSession $model)
    {
        parent::__construct($model);
    }

    public function createAttendance(array $data): Attendance
    {
        return Attendance::create($data);
    }

    public function findSessionByQr(string $qrCode): ?AttendanceSession
    {
        return $this->model->where('qr_code', $qrCode)->first();
    }
}
