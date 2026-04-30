<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controllers\BaseController;
use App\Modules\Products\Requests\StoreProductRequest;
use App\Modules\Products\Resources\ProductResource;
use App\Modules\Products\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function __construct(private ProductService $productService) {}

    public function index(): JsonResponse
    {
        $products = $this->productService->getAll();
        return $this->successResponse(ProductResource::collection($products), 'Products retrieved successfully');
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());
        return $this->successResponse(new ProductResource($product), 'Product created successfully', 201);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->findById($id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        return $this->successResponse(new ProductResource($product), 'Product retrieved successfully');
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $product = $this->productService->update($id, $request->all());
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }
        return $this->successResponse(new ProductResource($product), 'Product updated successfully');
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->productService->delete($id);
        if (!$deleted) {
            return $this->errorResponse('Product not found', 404);
        }
        return $this->successResponse(null, 'Product deleted successfully');
    }
}
