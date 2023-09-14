<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResultResource\Pages;
use App\Filament\Resources\QuizResultResource\RelationManagers;
use App\Models\QuizResult;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResultResource extends Resource
{
    protected static ?string $model = QuizResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Forms\Components\Select::make('quiz_id')
                                                ->relationship('quiz', 'title')
                                                ->required(),

                         Forms\Components\Toggle::make('verify')
                                                ->required(),

                         Forms\Components\Textarea::make('data')
                                                  ->required(),

                         Forms\Components\Textarea::make('curator_comment')
                                                  ->maxLength(65535),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('id')
                                                   ->toggleable(isToggledHiddenByDefault: true),
                          Tables\Columns\TextColumn::make('user.email')
                                                   ->toggleable(isToggledHiddenByDefault: false),
                          Tables\Columns\TextColumn::make('quiz.title')
                                                   ->toggleable(isToggledHiddenByDefault: false),
                          Tables\Columns\TextColumn::make('data')
                                                   ->tooltip(fn($record) => $record->data)
                                                   ->limit(15)
                                                   ->toggleable(isToggledHiddenByDefault: false),
                          Tables\Columns\IconColumn::make('verify')
                                                   ->boolean(),
                          Tables\Columns\TextColumn::make('curator_comment')
                                                   ->toggleable(isToggledHiddenByDefault: true),
                          Tables\Columns\TextColumn::make('created_at')
                                                   ->toggleable(isToggledHiddenByDefault: true)
                                                   ->dateTime(),
                          Tables\Columns\TextColumn::make('updated_at')
                                                   ->dateTime(),
                      ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                          //
                      ])
            ->actions([
                          Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListQuizResults::route('/'),
            'create' => Pages\CreateQuizResult::route('/create'),
            'view'   => Pages\ViewQuizResult::route('/{record}'),
            'edit'   => Pages\EditQuizResult::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('admin-panel.quiz_result');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin-panel.quiz_results');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    protected static function getNavigationGroup(): string
    {
        return __('admin-panel.app');
    }
}
