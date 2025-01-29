<?php

namespace Tests\Feature\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_create_order()
    {
        $user = User::where('email', 'admin@admin')->first();

        $product = Product::factory()->create();
        $data = [
            'customer_phone' => '1234567890',
            'customer_name' => 'Олег',
            'type' => 'Самовывоз',
            'products' => [
                ['product_id' => $product->id, 'quantity' => 2],
            ],
        ];

        $response = $this->actingAs($user)->post('/api/v1/orders', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', ['customer_phone' => '1234567890']);
    }

    /** @test */
    public function can_get_order_details()
    {
        $user = User::where('email', 'admin@admin')->first();

        $order = Order::factory()->create();

        $response = $this->actingAs($user)->get('/api/v1/orders/'.$order->id);
        $response->assertStatus(200);
        $response->assertSee($order->customer_phone);
    }

    /** @test */
    public function can_list_orders()
    {
        $user = User::where('email', 'admin@admin')->first();

        $order = Order::factory()->create();
        $orderProduct = OrderProduct::factory()->create(
            [
                'order_id' => $order->id,
            ]
        );
        $orderProduct2 = OrderProduct::factory()->create(
            [
                'order_id' => $order->id,
            ]
        );

        $response = $this->actingAs($user)->get('/api/v1/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'customer_phone',
                        'status',
                        'total_price',
                        'created_at',
                        'updated_at',
                        'order_products' => [
                            '*' => [
                                'product_id',
                                'quantity',
                                'price',
                                'created_at',
                                'updated_at',
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
