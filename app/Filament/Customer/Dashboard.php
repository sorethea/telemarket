<?php

namespace App\Filament\Customer;

class Dashboard extends \Filament\Pages\Dashboard
{
    /**
     * @return string|\Illuminate\Contracts\Support\Htmlable
     */
    public function getTitle(): string
    {
        return config('telegram.bots.ichiban.name');
    }
}
