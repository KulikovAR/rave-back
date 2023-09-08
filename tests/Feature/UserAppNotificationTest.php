<?php

namespace Tests\Feature;

use App\Notifications\UserAppNotification;
use Tests\TestCase;

class UserAppNotificationTest extends TestCase
{
    /**
     * Test view unread notification.
     */
    public function test_view_unread_notifications(): void
    {
        $this->getTestUser()->notify(new UserAppNotification(__('notifications.qiuz_verifed')));

        $response = $this->json(
            'get',
            route('notification.index'),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure($this->getPaginationResponse());

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'data' => [
                        'message'
                    ],
                    'created_at'
                ]
            ]
        ]);
    }


    /**
     * Test read notification.
     */
    public function test_read_notification(): void
    {
        $this->getTestUser()->notify(new UserAppNotification(__('notifications.qiuz_verifed')));

        $response = $this->json(
            'post',
            route('notification.edit',[
                'id' => $this->getTestUser()->notifications()->first()->id
            ]),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);
    }
}