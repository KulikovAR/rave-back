<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($orderProduct) {
            $order = $orderProduct->order;
            $order->recalculateTotalPrice();
        });

        static::saving(function ($model) {
            if (! $model->price) {
                $product = Product::find($model->product_id);
                $model->price = $product?->price ?? 0;
            }
        });
    }
}
