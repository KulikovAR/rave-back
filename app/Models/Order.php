<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'customer_phone',
        'total_price',
        'status',
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    // public function calculateTotalPrice()
    // {
    //     $totalPrice = $this->orderProducts->sum(function ($orderProduct) {
    //         return $orderProduct->price * $orderProduct->quantity;
    //     });

    //     $this->total_price = $totalPrice;
    //     $this->save();
    // }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function recalculateTotalPrice()
    {
        $this->load('orderProducts');

        // Пересчитываем стоимость заказа, исходя из информации из order_products
        $totalPrice = $this->orderProducts->sum(function ($orderProduct) {
            return $orderProduct->price * $orderProduct->quantity;
        });

        // Обновляем поле total_price
        $this->update(['total_price' => $totalPrice]);
    }
}
