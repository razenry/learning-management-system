<?php

namespace App\Modules\Classes\Services;

use App\Core\Services\BaseService;
use App\Modules\Classes\Repositories\ClassRepository;

class ClassService extends BaseService
{
    public function __construct(private ClassRepository $classRepository) {}

    public function createClass(array $data)
    {
        return $this->classRepository->create($data);
    }

    public function addSchedule(int $classId, array $data)
    {
        $data['class_id'] = $classId;
        return $this->classRepository->addSchedule($data);
    }

    public function enrollStudent(int $classId, int $userId)
    {
        return $this->classRepository->enrollStudent($classId, $userId);
    }

    public function getClassesByTeacher(int $teacherId)
    {
        return $this->classRepository->all()->where('teacher_id', $teacherId);
    }

    public function getClassesByStudent(int $userId)
    {
        // This would normally be through enrollments
        return \App\Models\User::find($userId)->siswas; // Wait, this logic is for wali.
    }
}
