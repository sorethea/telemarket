<?php

namespace App\Filament\Marketing\Resources\MessageResource\Pages;

use App\Filament\Marketing\Resources\MessageResource;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;

class ReplyMessage extends Page implements HasForms, HasActions
{
    use InteractsWithForms, InteractsWithActions;
    protected static string $resource = MessageResource::class;

    protected static string $view = 'filament.marketing.resources.message-resource.pages.reply-message';

    public $mountedActionForm;
    public function form(Form $form): Form
    {
        return $form->schema([
            MarkdownEditor::make('text')
                ->required(fn($get)=>empty($get("file"))),
            FileUpload::make('file')
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
        ]);
    }
}
