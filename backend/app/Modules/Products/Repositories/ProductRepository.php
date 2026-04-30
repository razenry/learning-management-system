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
}
