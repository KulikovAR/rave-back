<?php

namespace App\Filament\Resources\ServiceScheduleResource\Pages;

use App\Filament\Resources\ServiceScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceSchedules extends ListRecords
{
    protected static string $resource = ServiceScheduleResource::class;

    public function mount(): void
    {
        $restaurantId = request()->get('restaurant');
        if ($restaurantId) {
            session(['restaurant_id' => $restaurantId]);
        }
    }

    protected function getHeaderActions(): array
    {
        $restaurantId = request()->get('restaurant');

        return [
            Actions\CreateAction::make()
                ->url(fn () => route('filament.admin.resources.service-schedules.create').'?restaurant='.$restaurantId),
        ];
    }

    public function getTitle(): string
    {
        return 'Список дней';
    }

    public function getBreadcrumb(): string
    {
        return 'Список';
    }
}
