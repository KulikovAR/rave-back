<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\QuizResultResource;
use App\Filament\Resources\SlideResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'quiz_results';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return QuizResultResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return QuizResultResource::table($table);
    }    
}
