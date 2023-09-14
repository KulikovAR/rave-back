<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Filament\Resources\CommentResource\RelationManagers\CommentsRelationManager;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         TextInput::make('body')
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
                          TextColumn::make('body'),
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
            CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit'   => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
