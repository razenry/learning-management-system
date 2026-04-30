<?php

namespace App\Modules\Hafiz\Controllers;

use App\Core\Controllers\BaseController;
use App\Modules\Hafiz\Services\HafizService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HafizController extends BaseController
{
    public function __construct(private HafizService $hafizService) {}

    public function recordProgress(Request $request): JsonResponse
    {
        $progress = $this->hafizService->recordProgress($request->all());
        return $this->successResponse($progress, 'Hafiz progress recorded successfully');
    }

    public function storeReport(Request $request): JsonResponse
    {
        $report = $this->hafizService->createReport($request->user()->id, $request->all());
        return $this->successResponse($report, 'Hafiz report created successfully');
    }

    public function studentProgress(int $studentId): JsonResponse
    {
        $progress = $this->hafizService->getStudentProgress($studentId);
        return $this->successResponse($progress, 'Hafiz progress retrieved successfully');
    }
}
