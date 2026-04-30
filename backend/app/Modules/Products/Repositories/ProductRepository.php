<?php

namespace App\Modules\Products\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Modules\Products\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getFilteredProducts(array $filters = [])
    {
        $query = $this->model->where('is_active', true);

        if (isset($filters['academic_level_id'])) {
            $query->where(function($q) use ($filters) {
                $q->where('academic_level_id', $filters['academic_level_id'])
                  ->orWhereNull('academic_level_id'); // Add-ons often have null
            });
        }

        if (isset($filters['year_active'])) {
            $query->where(function($q) use ($filters) {
                $q->where('year_active', $filters['year_active'])
                  ->orWhereNull('year_active');
            });
        }

        if (isset($filters['enable_tka']) && !$filters['enable_tka']) {
            $query->where('name', 'not like', '%TKA%');
        }

        return $query->with('academicLevel')->get();
    }
}
