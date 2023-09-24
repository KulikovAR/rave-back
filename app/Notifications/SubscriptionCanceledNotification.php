<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionCanceledNotification extends BaseNotification
{
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ваша подписка отменена.')
            ->greeting('Ваша подписка отменена.')
            ->line('Привет, это TrueSchool.')
            ->line('Ваша подписка успешно отменена.')
            ->line('Вы можете оформить новую подписку в личном кабинете!')
            ->action('Перейти', config('front-end.front_url'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
