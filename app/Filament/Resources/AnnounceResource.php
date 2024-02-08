<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use App\Models\Announce;
use App\Filament\MenuTitles;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\AnnounceResource\Pages;
use App\Filament\Resources\AnnounceResource\RelationManagers;

class AnnounceResource extends Resource
{
    protected static ?string $model = Announce::class;

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    protected static ?string $navigationGroup  = MenuTitles::CATEGORY_APP;
    protected static ?string $pluralModelLabel = 'Анонсы';
    protected static ?string $modelLabel       = 'Анонс';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                TextInput::make('title')
                    ->maxLength(255)
                    ->translateLabel()
                    ->required(),
                Textarea::make('description'),
                FileUpload::make('preview_path')
                    ->tooltip('Загрузите...')
                    ->enableDownload()
                    ->enableOpen()
                    ->columnSpanFull()
                    ->maxSize(25000)
                    ->required(),
                Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->searchable()
                    ->required(),
                DateTimePicker::make('release_at')
                    ->minDate(now())
                    ->required(),
                Checkbox::make('main'),
                ViewField::make('video_path')
                    ->view('livewire.chunkuploader')
                    ->tooltip("1.Выберите видео файл. 2. Нажмите на кнопку «Загрузить». 3. Дождитесь загрузки")
                    ->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          TextColumn::make('title')
                                    ->tooltip(fn($record) => $record->title)
                                    ->limit(15),
                          TextColumn::make('description')
                                    ->tooltip(fn($record) => $record->description)
                                    ->limit(15),
                          TextColumn::make('video_path')
                                    ->tooltip(fn($record) => $record->video_path)
                                    ->limit(15),
                          ImageColumn::make('preview_path'),
                          // TextColumn::make('tags'),
                          IconColumn::make('main')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->trueColor('success')
                                    ->falseIcon('heroicon-o-ban')
                                    ->falseColor('danger')
                                    ->alignCenter(),
                          TextColumn::make('release_at')
                                    ->dateTime()
                                    ->sortable(),
                          TextColumn::make('created_at')
                                    ->dateTime()
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: true),
                          TextColumn::make('updated_at')
                                    ->dateTime()
                                    ->sortable()
                                    ->toggleable(isToggledHiddenByDefault: true),
                      ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                          //
                      ])
            ->actions([
                          Tables\Actions\ActionGroup::make([
                                                               Tables\Actions\EditAction::make(),
                                                               Tables\Actions\ViewAction::make(),
                                                               Tables\Actions\DeleteAction::make(),
                                                           ])
                      ])
            ->bulkActions([
                              Tables\Actions\DeleteBulkAction::make(),
                          ]);
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
            'index'  => Pages\ListAnnounces::route('/'),
            'create' => Pages\CreateAnnounce::route('/create'),
            'edit'   => Pages\EditAnnounce::route('/{record}/edit'),
        ];
    }
}
