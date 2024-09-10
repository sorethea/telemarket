<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SettingCommand extends Settings
{

    public static function group(): string
    {
        return 'command';
    }
}