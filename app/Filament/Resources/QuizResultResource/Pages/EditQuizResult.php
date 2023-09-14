<?php

namespace App\Filament\Resources\QuizResultResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\QuizResultResource;
use Filament\Pages\Actions;

class EditQuizResult extends BaseEditAction
{
    protected static string $resource = QuizResultResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
