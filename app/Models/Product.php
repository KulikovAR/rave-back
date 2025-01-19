<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\PriorityTrait;

class Product extends Model
{
    use HasFactory, PriorityTrait, HasUuids;

    protected $fillable = ['category_id', 'name', 'description', 'price', 'weight', 'calories', 'hidden', 'priority'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function media()
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function recommendedProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'recommended_products',
            'product_id',
            'recommended_product_id'
        );
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
