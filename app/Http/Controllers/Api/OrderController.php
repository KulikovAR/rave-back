<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request): ApiJsonResponse
    {
        $orders = $this->orderService->getAllOrders($request->all());

        return new ApiJsonResponse(data: $orders);
    }

    public function show($id): ApiJsonResponse
    {
        $order = $this->orderService->getOrderById($id);

        if (! $order) {
            return new ApiJsonResponse(404, false, 'Order not found');
        }

        return new ApiJsonResponse(data: $order);
    }

    public function store(OrderRequest $request): ApiJsonResponse
    {
        $validated = $request->validated();

        $order = $this->orderService->createOrder($validated);

        return new ApiJsonResponse(201, data: $order);
    }

    public function update(Request $request, $id): ApiJsonResponse
    {
        $validated = $request->validate([
            'status' => 'sometimes|string|in:pending,processing,completed,canceled',
        ]);

        $order = $this->orderService->updateOrder($id, $validated);

        if (! $order) {
            return new ApiJsonResponse(404, false, 'Order not found');
        }

        return new ApiJsonResponse(data: $order);
    }

    public function destroy($id): ApiJsonResponse
    {
        $order = $this->orderService->deleteOrder($id);

        if (! $order) {
            return new ApiJsonResponse(404, false, 'Order not found');
        }

        return new ApiJsonResponse(message: 'Order deleted successfully');
    }
}
