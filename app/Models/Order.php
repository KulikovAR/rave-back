<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'customer_phone',
        'total_price',
        'status',
        'type',
        'customer_name',
        'city',
        'district',
        'street',
        'house',
        'entrance',
        'apartment',
        'comment',
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function recalculateTotalPrice()
    {
        $this->load('orderProducts');

        $totalPrice = $this->orderProducts->sum(function ($orderProduct) {
            return $orderProduct->price * $orderProduct->quantity;
        });

        $this->update(['total_price' => $totalPrice]);
    }
}
