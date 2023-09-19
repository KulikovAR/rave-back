<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Banner;
use App\Filament\MenuTitles;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BannerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BannerResource\RelationManagers;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon   = 'heroicon-o-collection';
    protected static ?string $navigationGroup  = MenuTitles::CATEGORY_APP;
    protected static ?string $pluralModelLabel = 'Баннеры';
    protected static ?string $modelLabel       = 'Баннер';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         TextInput::make('title')
                                  ->maxLength(255)->translateLabel()->required(),
                         TextInput::make('action_url')->required(),
                         FileUpload::make('img')
                                   ->tooltip('Загрузите...')
                                   ->enableDownload()
                                   ->enableOpen()
                                   ->columnSpanFull()
                                   ->maxSize(100000)
                                   ->required(),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          TextColumn::make('title')
                                    ->toggleable(isToggledHiddenByDefault: false),
                          ImageColumn::make('img')->size(180)
                                     ->tooltip(fn($record) => $record->thumbnail)
                                     ->toggleable(isToggledHiddenByDefault: false),
                          TextColumn::make('action_url')
                                    ->tooltip(fn($record) => $record->action_url)
                                    ->limit(15)
                                    ->toggleable(isToggledHiddenByDefault: false),
                          TextColumn::make('updated_at')
                                    ->toggleable(isToggledHiddenByDefault: true)
                                    ->dateTime()
                                    ->sortable(),
                      ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                          //
                      ])
            ->actions([
                          Tables\Actions\ActionGroup::make([
                                                               Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit'   => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
