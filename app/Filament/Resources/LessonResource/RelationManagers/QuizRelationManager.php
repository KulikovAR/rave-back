<?php

namespace App\Filament\Resources\LessonResource\RelationManagers;

use App\Filament\Resources\QuizResource;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizRelationManager extends RelationManager
{
    protected static string $relationship = 'quiz';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextColumn::make('lessons.title')
                    ->tooltip(fn($record) => $record->lessons->title)
                    ->limit(15)
                    ->searchable(),
                TextColumn::make('title')
                    ->tooltip(fn($record) => $record->title)
                    ->limit(15)
                    ->searchable(),
                TextColumn::make('duration')->sortable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')->url(
                    fn(Quiz $record): string => QuizResource::getUrl('edit', $record)
                )
                ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
