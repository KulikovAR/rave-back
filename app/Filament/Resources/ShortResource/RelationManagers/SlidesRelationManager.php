<?php

namespace App\Filament\Resources\ShortResource\RelationManagers;

use App\Filament\Resources\SlideResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SlidesRelationManager extends RelationManager
{
    protected static string $relationship = 'slides';

    protected static ?string $recordTitleAttribute = 'file';

    public static function form(Form $form): Form
    {
        return SlideResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return SlideResource::table($table)
            ->appendHeaderActions([CreateAction::make()]);
    }
}
