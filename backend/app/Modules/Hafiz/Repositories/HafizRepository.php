<?php

namespace App\Modules\Hafiz\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Modules\Hafiz\Models\HafizProgress;
use App\Modules\Hafiz\Models\HafizReport;

class HafizRepository extends BaseRepository
{
    public function __construct(HafizProgress $model)
    {
        parent::__construct($model);
    }

    public function createReport(array $data): HafizReport
    {
        return HafizReport::create($data);
    }

    public function getProgressByStudent(int $studentId)
    {
        return $this->model->where('student_id', $studentId)->orderBy('date', 'desc')->get();
    }
}
