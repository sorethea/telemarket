<?php

namespace App\Options;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel
{

    case male ="male";
    case female="female";
    public function getLabel(): ?string
    {
        return match ($this){
            self::male=>trans("clinic/patient.male"),
            self::female=>trans("clinic/patient.female"),
        };
    }
}
