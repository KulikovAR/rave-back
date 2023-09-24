<?php

namespace App\Filament\Resources;

use App\Filament\MenuTitles;
use App\Filament\Resources\FaqTagResource\Pages;
use App\Filament\Resources\FaqTagResource\RelationManagers;
use App\Filament\Resources\FaqTagResource\RelationManagers\FaqsRelationManager;
use App\Models\FaqTag;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FaqTagResource extends Resource
{
    protected static ?string $model = FaqTag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = MenuTitles::CATEGORY_APP;
    protected static ?string $pluralModelLabel = 'FAQ ';
    protected static ?string $modelLabel = 'FAQ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->maxLength(255)
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            FaqsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaqTags::route('/'),
            'create' => Pages\CreateFaqTag::route('/create'),
            'edit' => Pages\EditFaqTag::route('/{record}/edit'),
        ];
    }
}
