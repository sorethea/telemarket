<?php

namespace App\Options;

use Filament\Support\Contracts\HasLabel;

enum MaritalStatus:string implements HasLabel
{
    case single = "single";
    case married = "married";
    case divorced = "divorced";
    case partner = "partner";
    public function getLabel(): ?string
    {
        return match ($this){
            self::single=>trans("clinic/patient.single"),
            self::married=>trans("clinic/patient.married"),
            self::divorced=>trans("clinic/patient.divorced"),
            self::partner=>trans("clinic/patient.partner"),
        };
    }
}
