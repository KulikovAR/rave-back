<?php

namespace App\Filament\Resources\QuizResource\RelationManagers;

use App\Filament\Resources\QuizResultResource;
use App\Filament\Resources\UserResource;
use App\Models\QuizResult;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'quiz_results';

    protected static ?string $recordTitleAttribute = 'user.email';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user.email')
                    ->required()
                    ->maxLength(255),
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
                Tables\Actions\Action::make('user')->url(
                    fn(QuizResult $record): string => UserResource::getUrl('edit', ['record' => $record->user])
                ),
                Tables\Actions\Action::make('Edit')->url(
                    fn(QuizResult $record): string => QuizResultResource::getUrl('edit', ['record' => $record])
                ),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    } 
}
