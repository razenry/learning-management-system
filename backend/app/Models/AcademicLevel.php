<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Products\Models\Product;

class AcademicLevel extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
