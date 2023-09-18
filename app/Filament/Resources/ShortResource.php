<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Short;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ShortResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ShortResource\RelationManagers;
use App\Filament\Resources\ShortResource\RelationManagers\SlidesRelationManager;

class ShortResource extends Resource
{
    protected static ?string $model = Short::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                        TextInput::make('title')
                                  ->required()
                                  ->maxLength(255),

                        TextInput::make('view_count')
                                  ->regex('/^[0-9]+$/'),

                        FileUpload::make('thumbnail')
                                   ->tooltip('Загрузите...')
                                   ->label('Заставка')
                                   ->enableDownload()
                                   ->enableOpen()
                                   ->maxSize(12288)
                                   ->columnSpanFull(),
                        ViewField::make('video_path')
                                  ->view('livewire.chunkuploader'),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                        Tables\Columns\TextColumn::make('id')
                                                  ->toggleable(isToggledHiddenByDefault: true)
                                                   ->searchable(),
                        Tables\Columns\TextColumn::make('title')
                                                  ->toggleable(isToggledHiddenByDefault: false)
                                                   ->searchable()
                                                   ->tooltip(fn($record) => $record->title)
                                                   ->limit(15),
                        Tables\Columns\TextColumn::make('thumbnail')
                                                  ->toggleable(isToggledHiddenByDefault: false)
                                                   ->searchable()
                                                   ->tooltip(fn($record) => $record->title)
                                                   ->limit(15),
                        Tables\Columns\TextColumn::make('view_count')
                                                  ->toggleable(isToggledHiddenByDefault: true)
                                                   ->sortable(),
                        Tables\Columns\TextColumn::make('created_at')
                                                  ->toggleable(isToggledHiddenByDefault: true)
                                                   ->sortable()
                                                   ->dateTime(),
                        Tables\Columns\TextColumn::make('updated_at')
                                                  ->toggleable(isToggledHiddenByDefault: false)
                                                   ->sortable()
                                                   ->dateTime(),
                        Tables\Columns\TextColumn::make('video_path')
                                                  ->tooltip(fn($record) => $record->video_path)
                                                  ->limit(15),
                      ])
            ->filters([
                          //
                      ])
            ->actions([
                          ActionGroup::make([
                                                EditAction::make(),
                                                DeleteAction::make(),
                                            ])
                      ])
            ->bulkActions([
                              Tables\Actions\DeleteBulkAction::make(),
                          ]);
    }

    public static function getRelations(): array
    {
        return [
            SlidesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListShorts::route('/'),
            'create' => Pages\CreateShort::route('/create'),
            'view'   => Pages\ViewShort::route('/{record}'),
            'edit'   => Pages\EditShort::route('/{record}/edit'),
        ];
    }


    public static function getModelLabel(): string
    {
        return __('admin-panel.short');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin-panel.shorts');
    }


    protected static function getNavigationGroup(): string
    {
        return __('admin-panel.app');
    }
}
