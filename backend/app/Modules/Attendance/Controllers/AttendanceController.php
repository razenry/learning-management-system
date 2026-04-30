<?php

namespace App\Modules\Attendance\Controllers;

use App\Core\Controllers\BaseController;
use App\Modules\Attendance\Services\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceController extends BaseController
{
    public function __construct(private AttendanceService $attendanceService) {}

    public function generateQr(Request $request): JsonResponse
    {
        $session = $this->attendanceService->createSession(
            $request->get('class_id'),
            $request->user()->id,
            $request->only(['latitude', 'longitude', 'radius'])
        );
        return $this->successResponse($session, 'QR session generated successfully');
    }

    public function scan(Request $request): JsonResponse
    {
        $result = $this->attendanceService->scanQr(
            $request->user()->id,
            $request->get('qr_code'),
            $request->only(['latitude', 'longitude'])
        );

        if (isset($result['error'])) {
            return $this->errorResponse($result['error'], 400);
        }

        return $this->successResponse($result, 'Attendance recorded successfully');
    }
}
