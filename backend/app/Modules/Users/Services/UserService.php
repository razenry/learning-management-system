<?php

namespace App\Modules\Users\Services;

use App\Core\Services\BaseService;
use App\Modules\Users\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function __construct(private UserRepository $userRepository) {}

    public function getAll(int $perPage = 15)
    {
        return $this->userRepository->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);
        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }
        return $user;
    }

    public function update(int $id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = $this->userRepository->update($id, $data);
        if ($user && isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }
        return $user;
    }

    public function delete(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    public function assignWali(int $studentId, int $waliId)
    {
        return $this->userRepository->assignWali($studentId, $waliId);
    }

    public function getWaliOf(int $studentId)
    {
        return $this->userRepository->getWaliOf($studentId);
    }

    public function getSiswas(int $waliId)
    {
        return $this->userRepository->getSiswas($waliId);
    }
}
