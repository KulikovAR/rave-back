<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Filament\Resources\QuizResource\RelationManagers\QuizResultsRelationManager;
use App\Models\Quiz;
use Dompdf\FrameDecorator\Text;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('lesson_id')
                    ->relationship('lessons', 'title')
                    ->searchable()
                    ->required(),
                TextInput::make('title')
                    ->maxLength(255)
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->maxLength(65535),
                TextInput::make('duration')
                    ->integer()
                    ->required(),
                Repeater::make('data')->schema([
                    Textarea::make('question')
                            ->maxLength(65535),
                    Repeater::make('answers')->schema([
                        Textarea::make('answer')
                            ->maxLength(65535)
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lessons.title'),
                TextColumn::make('title'),
                TextColumn::make('duration'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('lesson')->url(
                    fn(Quiz $record): string => LessonResource::getUrl('edit', ['record' => $record->lessons])
                )
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            QuizResultsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit'   => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('admin-panel.quiz');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin-panel.quizzes');
    }

    protected static function getNavigationGroup(): string
    {
        return __('admin-panel.app');
    }
}