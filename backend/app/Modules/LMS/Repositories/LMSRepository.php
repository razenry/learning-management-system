<?php

namespace App\Modules\LMS\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Modules\LMS\Models\Material;
use App\Modules\LMS\Models\Assignment;
use App\Modules\LMS\Models\Question;
use App\Modules\LMS\Models\Submission;

class LMSRepository extends BaseRepository
{
    public function __construct(Material $model)
    {
        parent::__construct($model);
    }

    public function createAssignment(array $data): Assignment
    {
        return Assignment::create($data);
    }

    public function addQuestion(array $data): Question
    {
        return Question::create($data);
    }

    public function submitAssignment(array $data): Submission
    {
        return Submission::create($data);
    }

    public function getQuestions(int $assignmentId)
    {
        return Question::where('assignment_id', $assignmentId)->get();
    }
}
