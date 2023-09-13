<?php

namespace App\Filament\Resources\LessonResource\RelationManagers;

use App\Filament\Resources\CommentResource;
use App\Models\Comment;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Auth;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'body';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                    ->searchable(['id', 'email'])
                    ->default(Auth::user()->id)
                    ->required(),
                Forms\Components\TextInput::make('body')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.id'),
                Tables\Columns\TextColumn::make('user.userProfile.firstname'),
                Tables\Columns\TextColumn::make('user.userProfile.lastname'),
                Tables\Columns\TextColumn::make('nesting_comments_count')->counts('nesting_comments'),
                Tables\Columns\TextColumn::make('body'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')->url(
                    fn(Comment $record): string => CommentResource::getUrl('edit', $record)
                )
                ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}