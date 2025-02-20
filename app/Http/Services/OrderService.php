<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrderService
{
    public function getAllOrders($filters = [])
    {
        $query = Order::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['customer_phone'])) {
            $query->where('customer_phone', 'like', '%'.$filters['customer_phone'].'%');
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
                'customer_name' => $data['customer_name'],
                'type' => $data['type'],
                'city' => $data['city'] ?? null,
                'district' => $data['district'] ?? null,
                'street' => $data['street'] ?? null,
                'house' => $data['house'] ?? null,
                'entrance' => $data['entrance'] ?? null,
                'apartment' => $data['apartment'] ?? null,
                'comment' => $data['comment'] ?? null,
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

            $this->sendTelegramNotification($order);

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

    private function sendTelegramNotification($order)
    {
        $chatIds = [
            'rave-burger' => env('TELEGRAM_CHAT_RAVE_BURGER'),
            'rave-bistro' => env('TELEGRAM_CHAT_RAVE_BISTRO'),
            'asiabar' => env('TELEGRAM_CHAT_RAVE_SUSHI'),
        ];

        $managerChatId = env('TELEGRAM_MANAGER_CHAT_ID');
        $botToken = env('TELEGRAM_API_TOKEN');

        $restaurantSlug = null;
        $firstProduct = $order->orderProducts->first()->product ?? null;

        if ($firstProduct && $firstProduct->category && $firstProduct->category->restaurant) {
            $restaurant = $firstProduct->category->restaurant;
            $restaurantName = $restaurant->name;
            $restaurantSlug = $restaurant->slug; // Берём slug для идентификации
        }
        
        $message = "Новый заказ!\n\n";

        $message .= "Заведение: {$restaurantName}\n";
        $message .= "Тип заказа: {$order->type}\n";

        if ($order->type === 'Доставка') {
            $addressParts = [];

            if (!empty($order->city)) {
                $addressParts[] = "{$order->city}";
            }
            if (!empty($order->district)) {
                $addressParts[] = "{$order->district} район";
            }
            if (!empty($order->street)) {
                $addressParts[] = "ул. {$order->street}";
            }
            if (!empty($order->house)) {
                $addressParts[] = "д. {$order->house}";
            }
            if (!empty($order->apartment)) {
                $addressParts[] = "кв. {$order->apartment}";
            }
            if (!empty($order->entrance)) {
                $addressParts[] = "(подъезд {$order->entrance})";
            }

            if (!empty($addressParts)) {
                $message .= "Адрес доставки: " . implode(', ', $addressParts) . "\n";
            }
        }

        $message .= "\nКлиент:\n";
        $message .= "-Имя: {$order->customer_name}\n";
        $message .= "-Тел: +{$order->customer_phone}\n";
        if (!empty($order->comment)) {
            $message .= "-Комментарий: {$order->comment}\n";
        }

        $message .= "\nПродукты:\n";

        foreach ($order->orderProducts as $orderProduct) {
            $message .= "- {$orderProduct->product->name} (x{$orderProduct->quantity})\n";
        }

        $message .= "\nСумма заказа: {$order->total_price}₽\n";

        // Отправляем в соответствующий чат ресторана
        if ($restaurantSlug && isset($chatIds[$restaurantSlug])) {
            Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatIds[$restaurantSlug],
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
        }

        // Отправляем главному менеджеру
        if ($managerChatId) {
            Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $managerChatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ]);
        }

    }
}
