<?php

namespace App\Modules\Reports\Controllers;

use App\Core\Controllers\BaseController;
use App\Modules\Reports\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminReportController extends BaseController
{
    public function __construct(private ReportService $reportService) {}

    public function dashboard(Request $request): JsonResponse
    {
        $summary = $this->reportService->getDashboardSummary();
        return $this->successResponse($summary, 'Dashboard summary retrieved');
    }

    public function finance(Request $request): JsonResponse
    {
        $report = $this->reportService->getFinanceReport($request->all());
        return $this->successResponse($report, 'Finance report retrieved');
    }

    public function attendance(Request $request): JsonResponse
    {
        $report = $this->reportService->getAttendanceReport($request->all());
        return $this->successResponse($report, 'Attendance report retrieved');
    }

    public function hafiz(Request $request): JsonResponse
    {
        $report = $this->reportService->getHafizReport($request->all());
        return $this->successResponse($report, 'Hafiz report retrieved');
    }
}
