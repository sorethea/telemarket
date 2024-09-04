<?php

namespace App\Filament\Profiles;
use Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo as BasePersonalInfo;
class PersonalInfo extends BasePersonalInfo
{
    protected function getProfileFormSchema(): array
    {
        $groupFields = Forms\Components\Group::make([
            $this->getNameComponent(),
            $this->getEmailComponent(),
        ])->columnSpan(2);

        return ($this->hasAvatars)
            ? [filament('filament-breezy')->getAvatarUploadComponent(), $groupFields]
            : [$groupFields];
    }
}
