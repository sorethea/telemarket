<?php

namespace App\Filament\Auth;
use Filament\Pages\Auth\Register as BaseRegister;
class Register extends BaseRegister
{
    /**
     * @return string|null
     */
    public function getTitle(): string
    {
        return config('telegram.bots.ichiban.name');
    }

}
