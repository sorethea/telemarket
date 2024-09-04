<?php

namespace App\Livewire\Profile;



use Jeffgreco13\FilamentBreezy\Pages\MyProfilePage;

class CustomerProfile extends MyProfilePage
{
    public function getRegisteredMyProfileComponents(): array
    {
        return [Contact::class];
    }
}
