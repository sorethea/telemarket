<?php

namespace App\Options;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasColor, HasLabel
{
    case Promotion = 'promotion';
    case Message = 'message';
    case Command = 'command';
    case Notification = 'notification';
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Promotion => 'warning',
            self::Notification => 'success',
            self::Command => 'danger',
            self::Message => 'gray',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Notification => trans('market.telegram.type.options.notification'),
            self::Promotion => trans('market.telegram.type.options.promotion'),
            self::Message => trans('market.telegram.type.options.message'),
            self::Command => trans('market.telegram.type.options.command'),
        };
    }
}
