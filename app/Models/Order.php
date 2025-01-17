<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_phone',
        'total_price',
        'status',
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function calculateTotalPrice()
    {
        $totalPrice = $this->orderProducts->sum(function ($orderProduct) {
            return $orderProduct->price * $orderProduct->quantity;
        });

        $this->total_price = $totalPrice;
        $this->save();
    }
}
