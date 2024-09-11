<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SettingCommand extends Settings
{
    public string $name;
    public string $text;
    public array $photos;

    public static function group(): string
    {
        return 'command';
    }
}
