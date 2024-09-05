<?php

namespace App\Filament\Resources\OrderPassengerResource\RelationManagers;

use App\Filament\Resources\OrderPassengerResource;
use App\Filament\Resources\PassengerResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersPassengerRelationManager extends RelationManager
{
    protected static string $relationship = 'orderPassenger';

    protected static ?string $recordTitleAttribute = 'order_id';

    public static function form(Form $form): Form
    {
        return OrderPassengerResource::form($form);
    }

    public static function table(Table $table): Table

    {
        return OrderPassengerResource::table($table);
    }
}
