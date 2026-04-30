<?php

namespace App\Modules\Users\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Models\User;
use App\Modules\Users\Models\WaliRelation;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository
{
    private WaliRelation $waliRelation;

    public function __construct(User $model, WaliRelation $waliRelation)
    {
        parent::__construct($model);
        $this->waliRelation = $waliRelation;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('roles')->paginate($perPage);
    }

    public function assignWali(int $studentId, int $waliId): WaliRelation
    {
        return $this->waliRelation->updateOrCreate(
            ['student_id' => $studentId],
            ['wali_id' => $waliId]
        );
    }

    public function getWaliOf(int $studentId): ?WaliRelation
    {
        return $this->waliRelation->with('wali')->where('student_id', $studentId)->first();
    }

    public function getSiswas(int $waliId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->waliRelation->with('student')->where('wali_id', $waliId)->get();
    }

    public function getUsersByRole(string $role): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->role($role)->get();
    }
}
