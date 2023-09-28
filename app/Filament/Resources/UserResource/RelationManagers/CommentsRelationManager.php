<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\CommentResource;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return CommentResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return CommentResource::table($table)
            ->appendHeaderActions([CreateAction::make()]);
    }
}
