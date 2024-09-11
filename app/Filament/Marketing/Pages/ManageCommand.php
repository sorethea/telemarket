<?php

namespace App\Filament\Marketing\Pages;

use App\Settings\CommandSettings;
use App\Settings\SettingCommand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageCommand extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = SettingCommand::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Repeater::make("command")
                    ->schema([
                        Forms\Components\TextInput::make("name")->required(),
                        Forms\Components\TextInput::make("text")->nullable(),
                        Forms\Components\FileUpload::make("photo")->nullable(),
                    ])
                    ->label(trans("general.command.title")),
            ]);
    }
}
