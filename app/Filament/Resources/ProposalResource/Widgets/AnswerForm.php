<?php

namespace App\Filament\Resources\ProposalResource\Widgets;

use App\Models\User;
use App\Notifications\UserAppNotification;
use Filament\Resources\Form;
use Filament\Widgets\Widget;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class AnswerForm extends Widget implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    public ?Model $record = null;
    protected static string $view = 'filament.resources.proposal-resource.widgets.answer-form';

    public $answer = '';

    public function mount(): void
    {
        $this->form->fill();
    }
    public function submit(): void
    {
        $formData=$this->form->getState();
        $userId=$this->record->user_id;

        User::find($userId)->notify(new UserAppNotification($formData['answer']));

        $this->form->fill(["answer"=>'Отправлено...']);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Textarea::make('answer'),
        ];
    }
}
