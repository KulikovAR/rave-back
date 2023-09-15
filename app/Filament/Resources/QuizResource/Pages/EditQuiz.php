<?php

namespace App\Filament\Resources\QuizResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\QuizResource;
use Filament\Pages\Actions;

class EditQuiz extends BaseEditAction
{
    protected static string $resource = QuizResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
