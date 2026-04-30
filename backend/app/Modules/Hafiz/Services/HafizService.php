<?php

namespace App\Modules\Hafiz\Services;

use App\Core\Services\BaseService;
use App\Modules\Hafiz\Repositories\HafizRepository;

class HafizService extends BaseService
{
    public function __construct(private HafizRepository $hafizRepository) {}

    public function recordProgress(array $data)
    {
        return $this->hafizRepository->create($data);
    }

    public function createReport(int $teacherId, array $data)
    {
        $data['teacher_id'] = $teacherId;
        return $this->hafizRepository->createReport($data);
    }

    public function getStudentProgress(int $studentId)
    {
        return $this->hafizRepository->getProgressByStudent($studentId);
    }
}
