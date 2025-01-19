<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

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
            // После сохранения каждого OrderProduct пересчитываем стоимость заказа
            $order = $orderProduct->order;
            $order->recalculateTotalPrice(); // Вызываем перерасчет общей стоимости
        });

        static::saving(function ($model) {
            // Если цена не установлена, извлекаем её из модели продукта
            if (!$model->price) {
                $product = Product::find($model->product_id);
                $model->price = $product?->price ?? 0; // Если продукт не найден, установим цену 0
            }
            
        });
    }
}
