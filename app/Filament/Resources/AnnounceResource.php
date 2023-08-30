<?php

namespace App\Filament\Resources;

use App\Filament\MenuTitles;
use App\Filament\Resources\AnnounceResource\Pages;
use App\Filament\Resources\AnnounceResource\RelationManagers;
use App\Models\Announce;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class AnnounceResource extends Resource
{
    protected static ?string $model = Announce::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = MenuTitles::CATEGORY_APP;
    protected static ?string $pluralModelLabel = MenuTitles::MENU_ANNOUNCES;
    protected static ?string $modelLabel = MenuTitles::MENU_ANNOUNCE;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->maxLength(255)->translateLabel(),
                Textarea::make('description'),
                TextInput::make('video_path')
                    ->maxLength(255),
                FileUpload::make('preview_path'),
                Select::make('tags')
                    ->options(Tag::all()->pluck('name', 'id'))
                    ->searchable(),
                DateTimePicker::make('release_at')->minDate(now()),
                Checkbox::make('main')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('description'),
                TextColumn::make('video_path'),
                ImageColumn::make('preview_path'),
                TextColumn::make('tags'),
                IconColumn::make('main')
                    ->boolean()
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-check'),
                TextColumn::make('release_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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