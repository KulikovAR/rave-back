<?php

namespace App\Filament\Resources\FaqResource\Pages;

use App\Filament\BaseCreateAction;
use App\Filament\Resources\FaqResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFaq extends BaseCreateAction
{
    protected static string $resource = FaqResource::class;
}
