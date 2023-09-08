<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\LessonResource;
use Filament\Pages\Actions;

class EditLesson extends BaseEditAction
{
    protected static string $resource = LessonResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
