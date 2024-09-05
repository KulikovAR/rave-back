<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\PassengerResource;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;

class PassengerRelationManager extends RelationManager
{
    protected static string $relationship = 'passenger';

    protected static ?string $recordTitleAttribute = 'lastname';

    public static function form(Form $form): Form
    {
        return PassengerResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return PassengerResource::table($table);
    }
}
