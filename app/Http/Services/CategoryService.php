<?php

namespace App\Http\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories($hidden = null, $priority = null)
    {
        $query = Category::query();
        if ($hidden !== null) {
            $query->where('hidden', $hidden);
        }
        if ($priority !== null) {
            $query->orderBy('priority', 'asc');
        }
        return $query->get();
    }

    public function getCategoryById($id)
    {
        return Category::find($id);
    }

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory($id, array $data)
    {
        $category = Category::find($id);
        if ($category) {
            $category->update($data);
        }
        return $category;
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
        }
        return $category;
    }
}