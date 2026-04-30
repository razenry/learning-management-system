<?php

namespace App\Modules\Users\Controllers;

use App\Core\Controllers\BaseController;
use App\Modules\Users\Requests\StoreUserRequest;
use App\Modules\Users\Requests\UpdateUserRequest;
use App\Modules\Users\Requests\AssignWaliRequest;
use App\Modules\Users\Resources\UserResource;
use App\Modules\Users\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct(private UserService $userService) {}

    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->getAll($request->get('per_page', 15));
        return $this->successResponse(UserResource::collection($users), 'Users retrieved successfully');
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->validated());
        return $this->successResponse(new UserResource($user), 'User created successfully', 201);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userService->findById($id);
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }
        return $this->successResponse(new UserResource($user), 'User retrieved successfully');
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->update($id, $request->validated());
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }
        return $this->successResponse(new UserResource($user), 'User updated successfully');
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->userService->delete($id);
        if (!$deleted) {
            return $this->errorResponse('User not found or cannot be deleted', 404);
        }
        return $this->successResponse(null, 'User deleted successfully');
    }

    public function assignWali(AssignWaliRequest $request): JsonResponse
    {
        $relation = $this->userService->assignWali(
            $request->get('student_id'),
            $request->get('wali_id')
        );
        return $this->successResponse($relation, 'Wali assigned successfully');
    }

    public function getSiswas(int $waliId): JsonResponse
    {
        $siswas = $this->userService->getSiswas($waliId);
        return $this->successResponse($siswas, 'Students retrieved successfully');
    }
}
