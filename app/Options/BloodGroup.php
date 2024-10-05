<?php

namespace App\Options;

use Filament\Support\Contracts\HasLabel;

enum BloodGroup:string implements HasLabel
{
    case APlus ="a+";
    case BPlus ="b+";
    case ABPlus ="ab+";
    case OPlus ="o+";
    case AMinus ="a-";
    case BMinus ="b-";
    case ABMinus ="ab-";
    case OMinus ="o-";

    public function getLabel(): ?string
    {
        return match ($this){
            self::APlus=>trans("clinic/patient.a+"),
            self::BPlus=>trans("clinic/patient.b+"),
            self::ABPlus=>trans("clinic/patient.ab+"),
            self::OPlus=>trans("clinic/patient.o+"),
            self::AMinus=>trans("clinic/patient.a-"),
            self::BMinus=>trans("clinic/patient.b-"),
            self::ABMinus=>trans("clinic/patient.ab-"),
            self::OMinus=>trans("clinic/patient.o-"),
        };
    }
}
