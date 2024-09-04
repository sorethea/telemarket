<?php

namespace App\Filament\Profiles;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo as BasePersonalInfo;
class PersonalInfo extends BasePersonalInfo
{
    public array $only = ['name','email','phone_number'];
    protected function getProfileFormSchema(): array
    {
        $groupFields = Group::make([
            $this->getNameComponent(),
            $this->getPhoneComponent(),
            $this->getEmailComponent(),
        ])->columnSpan(2);

        return ($this->hasAvatars)
            ? [filament('filament-breezy')->getAvatarUploadComponent(), $groupFields]
            : [$groupFields];
    }
    protected function getPhoneComponent(): TextInput
    {
        return TextInput::make('phone_number')
            ->required()
            ->label(__('general.phone_number'));
    }
}
