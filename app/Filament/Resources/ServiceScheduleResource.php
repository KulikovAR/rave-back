<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceScheduleResource\Pages;
use App\Models\ServiceSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;

class ServiceScheduleResource extends Resource
{
    protected static ?string $model = ServiceSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected static ?string $navigationLabel = 'Расписание';

    protected static ?string $navigationGroup = 'Рестораны';

    public static function form(Form $form): Form
    {
        // Логируем запрос
        \Log::info('Restaurant ID from URL', ['restaurant' => request('restaurant')]);

        return $form
            ->schema([
                // Скрытое поле для restaurant_id
                Forms\Components\Hidden::make('restaurant_id')
                    ->default(request('restaurant'))  // Получаем restaurant_id из query-параметра
                    ->required(),
                
                Forms\Components\Select::make('day_of_week')
                    ->disabled()
                    ->options([
                        'Monday' => __('days.Monday'),
                        'Tuesday' => __('days.Tuesday'),
                        'Wednesday' => __('days.Wednesday'),
                        'Thursday' => __('days.Thursday'),
                        'Friday' => __('days.Friday'),
                        'Saturday' => __('days.Saturday'),
                        'Sunday' => __('days.Sunday'),
                    ]),
                Forms\Components\Toggle::make('is_open')
                    ->label('Открыто')
                    ->required(),
                Forms\Components\TimePicker::make('opening_time')
                    ->label('Время открытия')
                    ->nullable()
                    ->format('H:i'),
                Forms\Components\TimePicker::make('closing_time')
                    ->label('Время закрытия')
                    ->nullable()
                    ->format('H:i'),
            ]);
    }

    public static function table(Table $table): Table
    {
        $restaurantId = request()->get('restaurant');
        \Log::info('Restaurant ID from query', ['restaurant' => $restaurantId]);

        if (!$restaurantId) {
            throw new \RuntimeException('Параметр restaurant не передан в запросе.');
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('restaurant.name')->label('Ресторан'),
                Tables\Columns\TextColumn::make('day_of_week')
                    ->label('День недели')
                    ->getStateUsing(fn ($record) => __('days.' . $record->day_of_week)),
                Tables\Columns\BooleanColumn::make('is_open')->label('Открыто'),
                Tables\Columns\TextColumn::make('opening_time')
                    ->label('Время открытия')
                    ->getStateUsing(fn ($record) => $record->opening_time ? Carbon::parse($record->opening_time)->format('H:i') : null),  // Форматируем время
                Tables\Columns\TextColumn::make('closing_time')
                    ->label('Время закрытия')
                    ->getStateUsing(fn ($record) => $record->closing_time ? Carbon::parse($record->closing_time)->format('H:i') : null),  // Форматируем время
            ])
            ->query(fn () => ServiceSchedule::query()->where('restaurant_id', $restaurantId));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceSchedules::route('/'),
            'create' => Pages\CreateServiceSchedule::route('/create'),
            'edit' => Pages\EditServiceSchedule::route('/{record}/edit'),
        ];
    }
}