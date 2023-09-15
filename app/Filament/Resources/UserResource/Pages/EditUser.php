<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\SubscriptionTypeEnum;
use App\Filament\BaseEditAction;
use App\Filament\Resources\UserResource;
use Carbon\Carbon;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;

class EditUser extends BaseEditAction
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if(isset($data['subscription_type']) && !is_null($data['subscription_type'])) {
            if($data['subscription_type'] == SubscriptionTypeEnum::MONTH) {
                $data['subscription_expires_at'] = Carbon::now()->addDays(30);
            } elseif($data['subscription_type'] == SubscriptionTypeEnum::THREE_MOTHS) {
                $data['subscription_expires_at'] = Carbon::now()->addDays(180);
            } elseif($data['subscription_type'] == SubscriptionTypeEnum::YEAR) {
                $data['subscription_expires_at'] = Carbon::now()->addDays(365);
            }
            $data['subscription_created_at'] = now();
        }

        $record->update($data);

        return $record;
    }
}
