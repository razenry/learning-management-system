<?php

namespace App\Modules\Classes\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Modules\Classes\Models\ClassRoom;
use App\Modules\Classes\Models\ClassSchedule;
use App\Modules\Classes\Models\Enrollment;

class ClassRepository extends BaseRepository
{
    public function __construct(ClassRoom $model)
    {
        parent::__construct($model);
    }

    public function addSchedule(array $data): ClassSchedule
    {
        return ClassSchedule::create($data);
    }

    public function enrollStudent(int $classId, int $userId): Enrollment
    {
        return Enrollment::firstOrCreate([
            'class_id' => $classId,
            'user_id' => $userId
        ]);
    }
}
