<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getAllCategories($request->hidden, $request->priority);
        return response()->json($categories, 200);
    }

    public function show($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'restaurant_id' => 'required|exists:restaurants,id',
            'priority' => 'required|integer',
            'hidden' => 'required|boolean',
        ]);

        $category = $this->categoryService->createCategory($validated);

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'restaurant_id' => 'sometimes|exists:restaurants,id',
            'priority' => 'sometimes|integer',
            'hidden' => 'sometimes|boolean',
        ]);

        $category = $this->categoryService->updateCategory($id, $validated);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = $this->categoryService->deleteCategory($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}