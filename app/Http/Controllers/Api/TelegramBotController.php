<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\HandleMediaGroupJob;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TelegramBotController extends Controller
{
    protected Api $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function handleWebhook(Request $request)
    {
        $update = $request->all();
        Log::info('Telegram update:', $update);

        $getText = fn() => $update['message']['text'] ?? $update['message']['caption'] ?? '';
        $chatId = $update['message']['chat']['id'] ?? $update['callback_query']['message']['chat']['id'] ?? null;
        $user = $update['message']['from'] ?? $update['callback_query']['from'] ?? null;

        if (!$chatId || !$user) {
            // Невалидное обновление
            Log::warning('Invalid Telegram update received, missing chatId or user.');
            return;
        }

        $text = $getText();

        // Обработка команды "Новый отзыв" или callback_data = 'restart'
        if ($text === 'Новый отзыв' || ($update['callback_query']['data'] ?? '') === 'restart') {
            $this->sendRestaurantsKeyboard($chatId);

            if (isset($update['callback_query'])) {
                $this->telegram->editMessageReplyMarkup([
                    'chat_id' => $chatId,
                    'message_id' => $update['callback_query']['message']['message_id'],
                    'reply_markup' => json_encode(['inline_keyboard' => []]),
                ]);
            }

            Cache::put("step_$chatId", 'restaurant');
            return;
        }

        // Обработка команды /start
        if ($text === '/start') {
            $this->sendRestaurantsKeyboard($chatId);
            Cache::put("step_$chatId", 'restaurant');
            return;
        }

        $step = Cache::get("step_$chatId");

        if (isset($update['callback_query']['data']) && str_starts_with($update['callback_query']['data'], 'restaurant_')) {
            $selectedRestaurant = str_replace('restaurant_', '', $update['callback_query']['data']);

            Cache::put("restaurant_$chatId", $selectedRestaurant);
            Cache::put("step_$chatId", 'feedback');

            // Удалим inline-кнопки после выбора
            $this->telegram->editMessageReplyMarkup([
                'chat_id' => $chatId,
                'message_id' => $update['callback_query']['message']['message_id'],
                'reply_markup' => json_encode(['inline_keyboard' => []]),
            ]);

            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Напишите ваш отзыв (можно прикрепить фото):',
                'reply_markup' => json_encode(['remove_keyboard' => true]),
            ]);

            return;
        }

        if ($step === 'restaurant' && $text) {
            // Получаем список ресторанов
            $response = Http::get(env('APP_URL') . '/api/v1/restaurants');
            $restaurants = collect($response->json('data', []));

            // Проверяем, есть ли введённое название среди ресторанов
            $matched = $restaurants->firstWhere('name', $text);

            if (!$matched) {
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Пожалуйста, выберите ресторан из списка ниже 👇',
                ]);

                $this->sendRestaurantsKeyboard($chatId);
                return;
            }

            // Всё ок — сохраняем ресторан
            Cache::put("restaurant_$chatId", $text);
            Cache::put("step_$chatId", 'feedback');

            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Напишите ваш отзыв (можно прикрепить фото):',
                'reply_markup' => json_encode(['remove_keyboard' => true]),
            ]);
            return;
        }

        if ($step === 'feedback') {
            $this->handleFeedbackStep($update, $chatId, $user);
            return;
        }

        // Дополнительная логика, если нужна
    }

    protected function sendRestaurantsKeyboard(int $chatId): void
    {
        $response = Http::get(env('APP_URL') . '/api/v1/restaurants');
        $restaurants = $response->json('data', []);

        // Inline-кнопки (две в ряд)
        $inline = ['inline_keyboard' => []];
        foreach (array_chunk($restaurants, 2) as $row) {
            $inlineRow = [];
            foreach ($row as $restaurant) {
                $inlineRow[] = [
                    'text' => $restaurant['name'],
                    'callback_data' => 'restaurant_' . $restaurant['name'],
                ];
            }
            $inline['inline_keyboard'][] = $inlineRow;
        }

        // Обычная клавиатура (по одному в строке)
        $keyboard = [
            'keyboard' => array_map(fn($r) => [$r['name']], $restaurants),
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];

        // 1. Сообщение с inline-кнопками
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Выберите ресторан с помощью кнопок ниже:',
            'reply_markup' => json_encode($inline),
        ]);

        // 2. Сообщение с обычной клавиатурой
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Или выберите ресторан с клавиатуры 👇',
            'reply_markup' => json_encode($keyboard),
        ]);
    }

    protected function handleFeedbackStep(array $update, int $chatId, array $user): void
    {
        $mediaGroupId = $update['message']['media_group_id'] ?? null;

        $username = $user['username'] ?? null;
        $userId = $user['id'] ?? null;
        $userLink = $username ? "https://t.me/$username" : "tg://user?id=$userId";

        $restaurant = Cache::get("restaurant_$chatId", 'неизвестное заведение');

        if ($mediaGroupId) {
            $this->handleMediaGroup($update, $chatId, $mediaGroupId, $restaurant, $userLink);
            return;
        }

        // Одиночное фото или просто текст
        $allPhotos = [];

        if (!empty($update['message']['photo'])) {
            $photo = end($update['message']['photo']);
            $allPhotos[] = $photo['file_id'];
        }

        $text = $update['message']['caption'] ?? $update['message']['text'] ?? '';

        $maxCaptionLength = 1024;
        $senderText = "\n\nОтправитель: $userLink";
        $baseCaptionPrefix = "Новый отзыв!\nЗаведение: $restaurant\nОтзыв: ";

        $maxTextLength = $maxCaptionLength - mb_strlen($baseCaptionPrefix) - mb_strlen($senderText);

        if (mb_strlen($text) > $maxTextLength) {
            $text = mb_substr($text, 0, $maxTextLength - 3) . '...';
        }

        $caption = $baseCaptionPrefix . $text;

        if (count($allPhotos) === 1) {
            $this->telegram->sendPhoto([
                'chat_id' => env('TELEGRAM_FEEDBACK_MANAGER_CHAT_ID'),
                'photo' => $allPhotos[0],
                'caption' => $caption . $senderText,
                'parse_mode' => 'HTML',
            ]);
        } else {
            $this->telegram->sendMessage([
                'chat_id' => env('TELEGRAM_FEEDBACK_MANAGER_CHAT_ID'),
                'text' => $caption . $senderText,
                'parse_mode' => 'HTML'
            ]);
        }

        Cache::forget("step_$chatId");
        Cache::forget("restaurant_$chatId");

        $this->sendRestartPrompt($chatId);
        Cache::put("step_$chatId", 'awaiting_restart');
    }

    protected function handleMediaGroup(array $update, int $chatId, string $mediaGroupId, string $restaurant, string $userLink): void
    {
        $photoCacheKey = "media_group_photos_{$chatId}_{$mediaGroupId}";
        $jobKey = "media_group_job_key_{$chatId}_{$mediaGroupId}";

        $messages = Cache::get($photoCacheKey, []);
        $alreadyExists = collect($messages)->contains(fn($m) => $m['message_id'] === $update['message']['message_id']);
        if (!$alreadyExists) {
            $messages[] = $update['message'];
            Cache::put($photoCacheKey, $messages, now()->addMinutes(5));
        }

        Cache::put("{$jobKey}_last_updated", now(), now()->addMinutes(5));

        if (!Cache::has($jobKey)) {
            Cache::put($jobKey, true, now()->addMinutes(5));

            HandleMediaGroupJob::dispatch(
                $chatId,
                $mediaGroupId,
                $restaurant,
                $userLink
            );

            Log::info("HandleMediaGroupJob dispatched", compact('chatId', 'mediaGroupId'));
        }
    }

    protected function sendRestartPrompt(int $chatId): void
    {
        $inlineKeyboard = [
            'inline_keyboard' => [
                [['text' => 'Новый отзыв', 'callback_data' => 'restart']],
            ],
        ];

        $keyboard = [
            'keyboard' => [['Новый отзыв']],
            'resize_keyboard' => true,
        ];

        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Спасибо за отзыв! Хотите оставить ещё один?',
            'reply_markup' => json_encode($inlineKeyboard),
        ]);

        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Или нажмите кнопку ниже 👇',
            'reply_markup' => json_encode($keyboard),
        ]);
    }
}