<?php

namespace App\Filament\Marketing\Resources\MessageResource\Pages;

use App\Filament\Marketing\Resources\MessageResource;
use Filament\Resources\Pages\Page;

class ReplyMessage extends Page
{
    protected static string $resource = MessageResource::class;

    protected static string $view = 'filament.marketing.resources.message-resource.pages.reply-message';

    protected function getForms(): array
    {
        return [
            Forms\Components\MarkdownEditor::make('text')
                                ->required(fn($get)=>empty($get("file"))),
                            Forms\Components\FileUpload::make('file')
                                ->multiple()
                                ->disk('public')
                                ->acceptedFileTypes([
                                    'image/jpg',
                                    'image/npg',
                                    'image/gif',
                                    'audio/ogg',
                                    'audio/oga',
                                    'video/mpeg',
                                    'video/mp4',
                                    'application/pdf',
                                    'application/zip',
                                    'text/plain'
                                ])
                                ->directory(fn($record)=>$record->customer_id.'/sent')
                                ->required(fn($get)=>empty($get("text"))),
        ];
    }
}
