<?php

namespace App\Notifications;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentSuccessNotification extends BaseNotification
{
    public Order $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

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
            ->subject('Ваша подписка продлена.')
            ->greeting('Ваша подписка продлена.')
            ->line('Привет, это TrueSchool.')
            ->line('Ваша подписка успешно продлена.')
            ->line('Цена: ' . $this->order->price . ' р')
            ->line('Тариф: ' . $this->order->duration . ' дней')
            ->line('Следующее списание произойдёт автоматически: '
                . Carbon::now()->addDays($this->order->duration)->format('d.m.Y'))
            ->line('Вы можете отменить подписку в личном кабинете!')
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
