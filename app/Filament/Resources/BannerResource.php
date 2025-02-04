<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationLabel(): string
    {
        return 'Баннеры';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Баннеры';
    }

    public static function getModelLabel(): string
    {
        return 'Баннер';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required(),
                Forms\Components\FileUpload::make('image_path')
                    ->disk('public')
                    ->directory('banners')
                    ->visibility('public')
                    ->image(),
                Forms\Components\TextInput::make('priority')
                    ->label('Приоритет')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Название'),
                Tables\Columns\ImageColumn::make('image_path')->label('Изображение'),
                Tables\Columns\TextColumn::make('priority')->label('Приоритет'),
            ])
            ->actions([
                Tables\Actions\Action::make('enable')
                    ->label('Включить')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        // Отключаем все баннеры
                        Banner::query()->update(['hidden' => true]);

                        // Включаем текущий баннер
                        $record->update(['hidden' => false]);
                    })
                    ->visible(fn ($record) => $record->hidden),
            ])
            ->defaultSort('priority', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
