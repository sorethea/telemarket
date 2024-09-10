<?php

namespace App\Filament\Marketing\Pages;

use App\Settings\CommandSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageCommand extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = CommandSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // ...
            ]);
    }
}
