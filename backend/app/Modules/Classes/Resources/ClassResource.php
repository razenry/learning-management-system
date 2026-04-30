<?php

namespace App\Modules\Classes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Products\Resources\ProductResource;
use App\Modules\Users\Resources\UserResource;

class ClassResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'product' => new ProductResource($this->product),
            'teacher' => new UserResource($this->teacher),
            'description' => $this->description,
            'is_active' => $this->is_active,
            'schedules' => $this->schedules,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
