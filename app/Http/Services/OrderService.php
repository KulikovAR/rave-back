<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getAllOrders($filters = [])
    {
        $query = Order::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['customer_phone'])) {
            $query->where('customer_phone', 'like', '%' . $filters['customer_phone'] . '%');
        }

        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $query->whereBetween('created_at', [$filters['date_from'], $filters['date_to']]);
        }

        $query->with('orderProducts');

        return $query->get();
    }

    public function getOrderById($id)
    {
        return Order::with('orderProducts.product')->find($id);
    }

    public function createOrder(array $data)
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_phone' => $data['customer_phone'],
                'total_price' => 0,
                'status' => 'new',
            ]);

            foreach ($data['products'] as $productData) {
                $product = Product::find($productData['product_id']);

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'price' => $product->price,
                ]);
            }

            $this->recalculateOrder($order);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateOrder($id, array $data)
    {
        $order = Order::find($id);
        if ($order) {
            $order->update($data);
        }
        return $order;
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
        }
        return $order;
    }

    public static function recalculateOrder($order)
    {
        $totalPrice = $order->orderProducts->sum(function ($orderProduct) {
            return $orderProduct->quantity * $orderProduct->price;
        });

        $order->update(['total_price' => $totalPrice]);
    }
}