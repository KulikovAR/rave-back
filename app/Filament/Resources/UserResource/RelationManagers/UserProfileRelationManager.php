<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\MenuTitles;
use App\Filament\Resources\UserProfileResource;
use App\Models\UserProfile;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class UserProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'userProfile';

    protected static ?string $recordTitleAttribute = 'lastname';

    public static function form(Form $form): Form
    {
        return UserProfileResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return UserProfileResource::table($table)
            ->appendHeaderActions([CreateAction::make()]);
    }
}
