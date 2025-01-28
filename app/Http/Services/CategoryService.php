<?php

namespace App\Http\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

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
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('categories', 'public');
        }

        return Category::create($data);
    }

    public function updateCategory($id, array $data)
    {

        $category = Category::find($id);
        if ($category) {
            if (isset($data['image'])) {
                $data['image'] = $data['image']->store('categories', 'public');
            }

            $category->update($data);
        }

        return $category;
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->delete();
        }

        return $category;
    }
}
