<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): ApiJsonResponse
    {
        $products = $this->productService->getAllProducts($request->all());

        return new ApiJsonResponse(data: $products);
    }

    public function show($id): ApiJsonResponse
    {
        $product = $this->productService->getProductById($id);

        if (! $product) {
            return new ApiJsonResponse(404, false, 'Product not found');
        }

        return new ApiJsonResponse(data: $product);
    }

    public function store(Request $request): ApiJsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'calories' => 'required|integer',
            'hidden' => 'boolean',
            'priority' => 'required|integer',
        ]);

        $product = $this->productService->createProduct($validated);

        return new ApiJsonResponse(201, data: $product);
    }

    public function update(Request $request, $id): ApiJsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|integer',
            'weight' => 'sometimes|integer',
            'calories' => 'sometimes|integer',
            'hidden' => 'sometimes|boolean',
            'priority' => 'sometimes|integer',
        ]);

        $product = $this->productService->updateProduct($id, $validated);

        if (! $product) {
            return new ApiJsonResponse(404, false, 'Product not found');
        }

        return new ApiJsonResponse(data: $product);
    }

    public function destroy($id): ApiJsonResponse
    {
        $product = $this->productService->deleteProduct($id);

        if (! $product) {
            return new ApiJsonResponse(404, false, 'Product not found');
        }

        return new ApiJsonResponse(message: 'Product deleted successfully');
    }
}
