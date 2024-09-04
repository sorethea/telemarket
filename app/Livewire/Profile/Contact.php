<?php

namespace App\Livewire\Profile;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;

class Contact extends MyProfileComponent
{
    protected string $view = "livewire.profile.contact";
    public array $only = ["phone_number"];
    public array $data;
    public $user;
    public $userClass;

    public function mount()
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
        $this->userClass = get_class($this->user);

        $this->form->fill($this->user->only($this->only));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone_number')
                    ->label(__('general.contact.phone_number'))
                    ->required()
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = collect($this->form->getState())->only($this->only)->all();
        $this->user->update($data);
        Notification::make()
            ->success()
            ->title(__('general.contact.notify'))
            ->send();
    }
}
