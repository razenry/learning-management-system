<?php

namespace App\Modules\LMS\Services;

use App\Core\Services\BaseService;
use App\Modules\LMS\Repositories\LMSRepository;

class LMSService extends BaseService
{
    public function __construct(private LMSRepository $lmsRepository) {}

    public function createMaterial(array $data)
    {
        return $this->lmsRepository->create($data);
    }

    public function createAssignment(array $data)
    {
        return $this->lmsRepository->createAssignment($data);
    }

    public function addQuestion(int $assignmentId, array $data)
    {
        $data['assignment_id'] = $assignmentId;
        return $this->lmsRepository->addQuestion($data);
    }

    public function submitAssignment(int $studentId, int $assignmentId, array $answers)
    {
        $questions = $this->lmsRepository->getQuestions($assignmentId);
        $score = 0;
        $totalPoints = 0;

        foreach ($questions as $question) {
            $totalPoints += $question->points;
            if ($question->type === 'mcq' && isset($answers[$question->id])) {
                if ($answers[$question->id] === $question->correct_answer) {
                    $score += $question->points;
                }
            }
        }

        return $this->lmsRepository->submitAssignment([
            'assignment_id' => $assignmentId,
            'student_id' => $studentId,
            'answers' => $answers,
            'score' => $score,
            'is_graded' => true, // Auto graded for MCQs
            'submitted_at' => now(),
        ]);
    }
}
