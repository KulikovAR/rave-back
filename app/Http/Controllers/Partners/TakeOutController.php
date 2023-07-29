<?php

namespace App\Http\Controllers\Partners;

use App\Http\Requests\Partners\TakeOutRequest;
use App\Http\Resources\TakeOutCollection;
use App\Http\Responses\ApiJsonResponse;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class TakeOutController
{
    public function index(Request $request)
    {
        $takeOuts = $request->user()->takeouts()
                            ->with(['takeoutable'])
                            ->orderBy('created_at', 'desc')
                            ->paginate(config('pagination.per_page'));

        return new TakeOutCollection($takeOuts);
    }

    public function store(TakeOutRequest $request)
    {
        $user = $request->user();

        $user->takeouts()
             ->with('takeoutable')
             ->create($request->validated());

        $message = __('partners.takeout_message_sent');

        NotificationService::notifyAdmin($user->email . " " . $message);

        return new ApiJsonResponse(message: $message);
    }
}