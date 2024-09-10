<?php

namespace App\Options;

use Filament\Support\Contracts\HasColor;

enum Status:string implements HasColor
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
}
