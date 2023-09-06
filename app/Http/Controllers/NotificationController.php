<?php

namespace App\Http\Controllers;

use App\Http\Resources\Notification\NotificationCollection;
use Illuminate\Http\Request;

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
        $this->authorize('view', [DatabaseNotification::class, $request->user()]);

        return new NotificationCollection(
            $request->user()->unreadNotifications()
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request)
    {
        $this->authorize('view', [DatabaseNotification::class, $request->user()]);

        return new NotificationCollection(
            $request->user()->unreadNotifications()
                ->paginate(config('pagination.per_page'))
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
