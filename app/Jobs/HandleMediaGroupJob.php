<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Api;

class HandleMediaGroupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $message;
    protected int $chatId;
    protected string $mediaGroupId;
    protected string $restaurant;
    protected string $userLink;

    public function __construct(int $chatId, string $mediaGroupId, string $restaurant, string $userLink)
    {
        $this->chatId = $chatId;
        $this->mediaGroupId = $mediaGroupId;
        $this->restaurant = $restaurant;
        $this->userLink = $userLink;
    }

    public function handle(): void
    {
        $jobKey = "media_group_job_key_{$this->chatId}_{$this->mediaGroupId}";
        $lastUpdated = Cache::get("{$jobKey}_last_updated");

        if ($lastUpdated) {
            // Приводим lastUpdated к объекту Carbon, если это строка
            if (!($lastUpdated instanceof Carbon)) {
                $lastUpdated = Carbon::parse($lastUpdated);
            }

            // Разница в секундах с учётом знака (false)
            $diff = now()->diffInSeconds($lastUpdated, false);

            Log::info("Last updated timestamp from cache", ['lastUpdated' => $lastUpdated]);
            Log::info("now", ['now' => now()]);
            Log::info("Difference in seconds between now and lastUpdated", ['diff' => $diff]);

            // Проверяем, что lastUpdated был не позже чем now (diff >= 0)
            // и не старше 3 секунд (diff < 3)
            if ($diff >= 0 && $diff < 3) {
                Log::info("Media group still receiving updates, rescheduling job", [
                    'chatId' => $this->chatId,
                    'mediaGroupId' => $this->mediaGroupId
                ]);

                self::dispatch(
                    $this->chatId,
                    $this->mediaGroupId,
                    $this->restaurant,
                    $this->userLink
                )->delay(now()->addSeconds(3));

                return;
            }
        }

        // === Дальше всё как у тебя ===
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $cacheKey = "media_group_photos_{$this->chatId}_{$this->mediaGroupId}";
        $messages = Cache::pull($cacheKey, []);

        Cache::forget($jobKey);
        Cache::forget("{$jobKey}_last_updated");

        if (empty($messages)) {
            Log::warning("No messages found in cache for media group", ['key' => $cacheKey]);
            return;
        }

        $allPhotos = [];
        foreach ($messages as $msg) {
            if (!empty($msg['photo'])) {
                $photo = end($msg['photo']);
                $allPhotos[] = $photo['file_id'];
            }
        }

        $text = $messages[0]['caption'] ?? $messages[0]['text'] ?? '';

        // Ограничение длины caption до 1024 символов с учётом остальных частей
        $maxCaptionLength = 1024;
        $senderText = "\n\nОтправитель: {$this->userLink}";
        $baseCaptionPrefix = "Новый отзыв!\nЗаведение: {$this->restaurant}\nОтзыв: ";

        // Вычисляем максимально допустимую длину текста в отзыве
        $maxTextLength = $maxCaptionLength - mb_strlen($baseCaptionPrefix) - mb_strlen($senderText);

        if (mb_strlen($text) > $maxTextLength) {
            $text = mb_substr($text, 0, $maxTextLength - 3) . '...';
        }

        $caption = $baseCaptionPrefix . $text;

        if (count($allPhotos) > 1) {
            $media = [];
            foreach ($allPhotos as $i => $fileId) {
                $item = ['type' => 'photo', 'media' => $fileId];
                if ($i === 0) {
                    $item['caption'] = $caption . $senderText;
                    $item['parse_mode'] = 'HTML';
                }
                $media[] = $item;
            }

            Log::info('Sending media group', ['media' => $media]);

            $telegram->sendMediaGroup([
                'chat_id' => env('TELEGRAM_FEEDBACK_MANAGER_CHAT_ID'),
                'media' => json_encode($media),
            ]);
        } elseif (count($allPhotos) === 1) {
            $telegram->sendPhoto([
                'chat_id' => env('TELEGRAM_FEEDBACK_MANAGER_CHAT_ID'),
                'photo' => $allPhotos[0],
                'caption' => $caption . $senderText,
                'parse_mode' => 'HTML',
            ]);
        } else {
            $telegram->sendMessage([
                'chat_id' => env('TELEGRAM_FEEDBACK_MANAGER_CHAT_ID'),
                'text' => $caption . $senderText,
                'parse_mode' => 'HTML',
            ]);
        }

        Cache::forget("step_{$this->chatId}");
        Cache::forget("restaurant_{$this->chatId}");

        // $telegram->sendMessage([
        //     'chat_id' => $this->chatId,
        //     'text' => 'Спасибо за отзыв! Хотите оставить ещё один?',
        //     'reply_markup' => json_encode([
        //         'inline_keyboard' => [[['text' => 'Новый отзыв', 'callback_data' => 'restart']]],
        //     ]),
        // ]);

        $inlineKeyboard = [
            'inline_keyboard' => [
                [['text' => 'Новый отзыв', 'callback_data' => 'restart']],
            ],
        ];

        $keyboard = [
            'keyboard' => [['Новый отзыв']],
            'resize_keyboard' => true,
        ];

        $telegram->sendMessage([
            'chat_id' => $this->chatId,
            'text' => 'Спасибо за отзыв! Хотите оставить ещё один?',
            'reply_markup' => json_encode($inlineKeyboard),
        ]);

        $telegram->sendMessage([
            'chat_id' => $this->chatId,
            'text' => 'Или нажмите кнопку ниже 👇',
            'reply_markup' => json_encode($keyboard),
        ]);
    }
}