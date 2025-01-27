<?php

namespace App\Filament\Resources\ServiceScheduleResource\Pages;

use App\Filament\Resources\ServiceScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceSchedules extends ListRecords
{
    protected static string $resource = ServiceScheduleResource::class;

    protected function getHeaderActions(): array
    {
        $restaurantId = request()->get('restaurant');
        \Log::info('Creating new service schedule header action', ['restaurant' => $restaurantId]);

        return [
            Actions\CreateAction::make()
                ->url(fn () => route('filament.admin.resources.service-schedules.create') . '?restaurant=' . $restaurantId),
        ];
    }

    public function getTitle(): string
    {
        return 'Список расписаний';
    }

    public function getBreadcrumb(): string
    {
        return 'Список';
    }
}