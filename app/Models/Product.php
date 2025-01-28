<?php

namespace App\Models;

use App\Traits\PriorityTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids, PriorityTrait;

    protected $fillable = ['category_id', 'name', 'description', 'price', 'weight', 'calories', 'hidden', 'new', 'priority'];

    public static function boot()
    {
        parent::boot();

        static::setGroupByField('category_id');
    }

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

    public function addRecommendedProduct(Product $product)
    {
        $this->recommendedProducts()->attach($product->id);
    }

    public function removeRecommendedProduct(Product $product)
    {
        $this->recommendedProducts()->detach($product->id);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
