<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\BaseEditAction;
use App\Filament\Resources\CommentResource;
use Filament\Pages\Actions;

class EditComment extends BaseEditAction
{
    protected static string $resource = CommentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
