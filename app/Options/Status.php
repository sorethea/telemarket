<?php

namespace App\Options;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status:string implements HasColor, HasLabel
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Cancel = 'cancel';
    case Rejected = 'rejected';
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Cancel => 'warning',
            self::Sent => 'success',
            self::Rejected => 'danger',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => trans('market.telegram.status.options.draft'),
            self::Cancel => trans('market.telegram.status.options.cancel'),
            self::Sent => trans('market.telegram.status.options.sent'),
            self::Rejected => trans('market.telegram.status.options.rejected'),
        };
    }
}
