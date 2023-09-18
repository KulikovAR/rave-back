<?php

namespace App\Http\Controllers;

use App\Http\Requests\UuidRequest;
use App\Http\Resources\Notification\NotificationCollection;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display all unread notifications.
     *
     * @return \App\Http\Resources\Notification\NotificationCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        return new NotificationCollection(
            $request->user()->notifications()
                ->paginate(config('pagination.per_page'))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display all unread notifications.
     *
     * @return \App\Http\Resources\Notification\NotificationCollection
     */
    public function show(Request $request)
    {
        $this->authorize('view', [DatabaseNotification::class, $request->user()]);

        return new NotificationCollection(
            $request->user()->notifications()
                ->paginate(config('pagination.per_page'))
        );
    }

    /**
     * Mark notification as read.
     *
     * @param \App\Http\Requests\UuidRequest $request
     *
     * @return \App\Http\Responses\ApiJsonResponse
     */
    public function edit(UuidRequest $request)
    {
        $notification = DatabaseNotification::findOrFail($request->id);

        $notification->markAsRead();

        return new ApiJsonResponse();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
