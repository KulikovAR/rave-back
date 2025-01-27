<?php

namespace App\Filament\Resources\ServiceScheduleResource\Pages;

use App\Filament\Resources\ServiceScheduleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateServiceSchedule extends CreateRecord
{
    protected static string $resource = ServiceScheduleResource::class;

    public function getBreadcrumb(): string
    {
        return 'Создать расписание';
    }

    public function getTitle(): string
    {
        return 'Создание расписания ресторана';
    }

    // Добавим логирование для проверки
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        \Log::info('Restaurant ID from form data', ['restaurant_id' => $data['restaurant_id']]);

        return $data;
    }
}