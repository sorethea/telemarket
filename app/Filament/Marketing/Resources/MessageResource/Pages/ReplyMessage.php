<?php

namespace App\Filament\Marketing\Resources\MessageResource\Pages;

use App\Filament\Marketing\Resources\MessageResource;
use Filament\Resources\Pages\Page;

class ReplyMessage extends Page
{
    protected static string $resource = MessageResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-left';

    protected static string $view = 'filament.marketing.resources.message-resource.pages.reply-message';
}
