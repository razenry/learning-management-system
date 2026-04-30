<?php

namespace App\Modules\LMS\Controllers;

use App\Core\Controllers\BaseController;
use App\Modules\LMS\Services\LMSService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LMSController extends BaseController
{
    public function __construct(private LMSService $lmsService) {}

    public function storeMaterial(Request $request): JsonResponse
    {
        $material = $this->lmsService->createMaterial($request->all());
        return $this->successResponse($material, 'Material created successfully', 201);
    }

    public function storeAssignment(Request $request): JsonResponse
    {
        $assignment = $this->lmsService->createAssignment($request->all());
        return $this->successResponse($assignment, 'Assignment created successfully', 201);
    }

    public function addQuestion(Request $request, int $assignmentId): JsonResponse
    {
        $question = $this->lmsService->addQuestion($assignmentId, $request->all());
        return $this->successResponse($question, 'Question added successfully');
    }

    public function submit(Request $request, int $assignmentId): JsonResponse
    {
        $submission = $this->lmsService->submitAssignment(
            $request->user()->id,
            $assignmentId,
            $request->get('answers')
        );
        return $this->successResponse($submission, 'Assignment submitted successfully');
    }
}
