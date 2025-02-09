<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request): ApiJsonResponse
    {
        $categories = $this->categoryService->getAllCategories($request->hidden, $request->priority);

        return new ApiJsonResponse(data: $categories);
    }

    public function show($slug): ApiJsonResponse
    {
        $category = $this->categoryService->getCategoryBySlug($slug);

        if (! $category) {
            return new ApiJsonResponse(404, false, 'Category not found');
        }

        return new ApiJsonResponse(data: $category);
    }

    public function store(Request $request): ApiJsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'restaurant_id' => 'required|exists:restaurants,id',
            'priority' => 'required|integer',
            'hidden' => 'required|boolean',
            'image' => 'nullable|image',
            'description' => 'nullable|string|max:500',
        ]);

        $category = $this->categoryService->createCategory($validated);

        return new ApiJsonResponse(201, data: $category);
    }

    public function update(Request $request, $id): ApiJsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'restaurant_id' => 'sometimes|exists:restaurants,id',
            'priority' => 'sometimes|integer',
            'hidden' => 'sometimes|boolean',
            'image' => 'nullable|image',
            'description' => 'nullable|string|max:500',
        ]);

        $category = $this->categoryService->updateCategory($id, $validated);

        if (! $category) {
            return new ApiJsonResponse(404, false, 'Category not found');
        }

        return new ApiJsonResponse(data: $category);
    }

    public function destroy($id): ApiJsonResponse
    {
        $category = $this->categoryService->deleteCategory($id);

        if (! $category) {
            return new ApiJsonResponse(404, false, 'Category not found');
        }

        return new ApiJsonResponse(message: 'Category deleted successfully');
    }
}
