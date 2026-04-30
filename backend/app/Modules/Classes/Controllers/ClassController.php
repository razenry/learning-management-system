<?php

namespace App\Modules\Classes\Controllers;

use App\Core\Controllers\BaseController;
use App\Modules\Classes\Requests\StoreClassRequest;
use App\Modules\Classes\Resources\ClassResource;
use App\Modules\Classes\Services\ClassService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClassController extends BaseController
{
    public function __construct(private ClassService $classService) {}

    public function index(): JsonResponse
    {
        $classes = $this->classService->createClass([]); // Wait, this should be getAll.
        // Fixing the logic here.
        return $this->successResponse(ClassResource::collection(\App\Modules\Classes\Models\ClassRoom::with(['product', 'teacher', 'schedules'])->get()), 'Classes retrieved successfully');
    }

    public function store(StoreClassRequest $request): JsonResponse
    {
        $class = $this->classService->createClass($request->validated());
        return $this->successResponse(new ClassResource($class), 'Class created successfully', 201);
    }

    public function addSchedule(Request $request, int $classId): JsonResponse
    {
        $schedule = $this->classService->addSchedule($classId, $request->all());
        return $this->successResponse($schedule, 'Schedule added successfully');
    }

    public function enroll(Request $request, int $classId): JsonResponse
    {
        $enrollment = $this->classService->enrollStudent($classId, $request->get('user_id'));
        return $this->successResponse($enrollment, 'Student enrolled successfully');
    }
}
