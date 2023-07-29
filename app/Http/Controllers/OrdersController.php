<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\StoreOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Http\Requests\UuidRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Http\Responses\ApiJsonResponse;
use App\Interfaces\FetchFlightInterface;
use App\Interfaces\XmlParserInterface;
use App\Models\Order;
use App\Models\Promocode;
use App\Services\OrderService;
use App\Services\TripsFetcherService;
use App\Services\XmlParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
        public XmlParserInterface     $xmlParserService = new XmlParserService(),
        public FetchFlightInterface   $fetchFlightService = new TripsFetcherService(),
    ) {}

    public function index(UuidRequest $request)
    {
        if ($this->isModelIdRequest($request)) {
            return $this->show($request);
        }

        $collection = request()->user('sanctum')
                               ?->order()
                               ->with('orderPassenger')
                               ->orderBy('updated_at', 'desc')
                               ->paginate(config('pagination.per_page'));

        return $collection ? new OrderCollection($collection) : new ApiJsonResponse();
    }

    public function show(UuidRequest $request)
    {
        $orders =
            $request->user('sanctum')?->order()->with('orderPassenger')->findOrFail($request->id)
            ??
            Order::with('orderPassenger')->findOrFail($request->id);

        return new ApiJsonResponse(data: new OrderResource($orders));
    }

    public function update(UpdateOrderRequest $request)
    {
        $order = Order::where([
                                  'id'           => $request->id,
                                  'order_number' => $request->order_number,
                                  'order_status' => Order::CREATED
                              ])
                      ->firstOrFail();

        DB::beginTransaction();

        $order->orderPassenger()->delete();
        $order->forceDelete();

        $order = $this->createOrder($request);

        DB::commit();

        list($reservationToToken, $reservationFromToken)
            = $this->orderService->reserveBooking($request, $this->fetchFlightService, $this->xmlParserService);

        $order->reservation_to_token   = $reservationToToken;
        $order->reservation_from_token = $reservationFromToken;
        $order->save();

        return new ApiJsonResponse(data: new OrderResource($order));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = $this->createOrder($request);

        list($reservationToToken, $reservationFromToken)
            = $this->orderService->reserveBooking($request, $this->fetchFlightService, $this->xmlParserService);

        $order->reservation_to_token   = $reservationToToken;
        $order->reservation_from_token = $reservationFromToken;
        $order->save();

        return new ApiJsonResponse(data: new OrderResource($order));
    }

    public function destroy(Request $request)
    {
        $request->user()->order()->findOrFail($request->id)->delete();

        return new ApiJsonResponse();
    }

    private function createOrder(StoreOrderRequest|UpdateOrderRequest $request): Order
    {
        $requestValidated = $request->validated();

        $passengersArr = $requestValidated['passengers'];

        if (!empty($request->promo_code)) {
            $promoCode = Promocode::where(['promo_code' => $request->promo_code])->first();
        }

        list($order) = $this->orderService
            ->saveOrderWithPassengers($request, $passengersArr, $promoCode ?? null);

        $this->orderService
            ->isOrderMadeByExistingUser($request->email, $order);

        return $order;
    }
}
