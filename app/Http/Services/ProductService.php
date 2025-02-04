<?php

namespace App\Http\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts($filters = [])
    {
        $query = Product::query();

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['hidden'])) {
            $query->where('hidden', $filters['hidden']);
        }

        if (isset($filters['new'])) {
            $query->where('new', $filters['new']);
        }

        if (isset($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }

        if (isset($filters['priority'])) {
            $query->orderBy('priority', 'asc');
        }

        return $query->with('media')->get();
    }

    public function getProductById($id)
    {
        return Product::with(['media', 'recommendedProducts'])->find($id);
    }

    public function getProductBySlug($slug)
    {
        return Product::with(['media', 'recommendedProducts'])->where('slug', $slug)->first();
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($data);

            if (isset($data['recommended_products'])) {
                $product->recommendedProducts()->sync($data['recommended_products']);
            }
        }

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        }

        return $product;
    }
}
