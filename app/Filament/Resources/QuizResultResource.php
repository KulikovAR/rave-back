<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResultResource\Pages;
use App\Filament\Resources\QuizResultResource\RelationManagers;
use App\Models\QuizResult;
use App\Models\Role;
use App\Notifications\UserAppNotification;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResultResource extends Resource
{
    protected static ?string $model = QuizResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('quiz_id')
                    ->relationship('quiz', 'title')
                    ->required(),

                Forms\Components\Toggle::make('verify')
                    ->required(),

                Repeater::make('data')->schema([
                    Textarea::make('question')
                        ->maxLength(65535),
                    Textarea::make('answer')
                        ->maxLength(65535),
                    Checkbox::make('correct')
                ]),

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
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('quiz.title')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\IconColumn::make('verify')
                    ->sortable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('curator_comment')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('manager_id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->dateTime(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('handle')
                        ->action(function (QuizResult $record) {
                            $record->manager_id = auth()->user()->id;
                            $record->save();
                        })
                        ->label('Обработать')
                        ->color('warning')
                        ->icon('heroicon-o-paper-clip')
                        ->requiresConfirmation(),
                    Action::make('finished')
                        ->action(function (QuizResult $record) {
                            $record->verify = 1;
                            $record->save();

                            $record->user->notify(new UserAppNotification('Ваш тест проверен'));
                        })
                        ->label('Выполнено')
                        ->icon('heroicon-o-mail')
                        ->color('success')
                        ->requiresConfirmation(),
                    Action::make('cancel')
                        ->action(function (QuizResult $record) {
                            $record->manager_id = null;
                            $record->save();
                        })
                        ->label('Отменить')
                        ->color('danger')
                        ->icon('heroicon-o-x')
                        ->requiresConfirmation(),
                    EditAction::make(),
                ])
            ])
            ->prependActions([
                Tables\Actions\Action::make('View quiz')
                    ->label('Quiz')
                    ->color('default')
                    ->icon('heroicon-s-user-circle')
                    ->url(fn($record): string => QuizResource::getUrl('edit', ['record' => $record->quiz])),

                Tables\Actions\Action::make('View user')
                    ->label('Юзер')
                    ->color('success')
                    ->icon('heroicon-s-user-circle')
                    ->url(fn($record): string => UserResource::getUrl('edit', ['record' => $record->user])),
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
            'index' => Pages\ListQuizResults::route('/'),
            'create' => Pages\CreateQuizResult::route('/create'),
            'view' => Pages\ViewQuizResult::route('/{record}'),
            'edit' => Pages\EditQuizResult::route('/{record}/edit'),
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
