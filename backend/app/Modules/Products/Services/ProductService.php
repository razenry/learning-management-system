<?php

namespace App\Modules\Products\Services;

use App\Core\Services\BaseService;
use App\Modules\Products\Repositories\ProductRepository;

class ProductService extends BaseService
{
    public function __construct(private ProductRepository $productRepository) {}

    public function getAll(?int $academicLevelId = null)
    {
        $filters = [
            'year_active' => config('lms.active_academic_year'),
            'enable_tka' => config('lms.enable_tka'),
        ];

        if ($academicLevelId) {
            $filters['academic_level_id'] = $academicLevelId;
        }

        return $this->productRepository->getFilteredProducts($filters);
    }

    public function findById(int $id)
    {
        return $this->productRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}
