<?php

namespace App\Filament\Marketing\Resources\MessageResource\Pages;

use App\Filament\Marketing\Resources\MessageResource;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

class ReplyMessage extends Page implements HasForms, HasActions
{
    use InteractsWithForms, InteractsWithActions;
    protected static string $resource = MessageResource::class;

    protected $listeners =["saveVoice"];
    public bool $showStop = false;
    public bool $showPlay = false;
    public bool $showRecord = true;

    public string $audio = '';
    public File $audioFile;

    protected static string $view = 'filament.marketing.resources.message-resource.pages.reply-message';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            MarkdownEditor::make('text')
                ->required(fn($get)=>empty($get("file") && $get("voice"))),
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
                ->required(fn($get)=>empty($get("text") && $get("voice"))),
//            FileUpload::make('voice')
//                ->disk('public')
//                ->directory(fn($record)=>$record->customer_id.'/sent')
//                ->label("Voice")
//                ->required(fn($get)=>empty($get("text") && $get("file"))),
        ]);
    }
    public function getFormActions(): array
    {
        return [
            Action::make("reply")
                ->icon('heroicon-o-arrow-uturn-left'),
        ];
    }

    public function voiceRecord(): void
    {
        $this->dispatch('voiceRecordStart',['message'=>"This is a dispatch."]);
        Notification::make('voice-record')
            ->title("Vice Record")
            ->body("Record voice and send through telegram.")
            ->send();
        $this->showStop = true;
    }
//    public function voicePlay(): void
//    {
//        Notification::make('voice-record')
//            ->title("Vice Record")
//            ->body("Record voice and send through telegram.")
//            ->send();
//    }
    public function voiceStop(): void
    {
        $this->showPlay = true;
        $this->dispatch('voiceRecordStop',['message'=>"This is a dispatch."]);

        Notification::make('voice-record')
            ->title("Vice Record")
            ->body("Record voice and send through telegram.")
            ->send();
        //$this->saveVoice();


    }
//    public function saveVoice($form): void{
//        dd($url);
//        $audio = request()->file('audio');
//        $fileName = Str::random(32).".wav";
//        Storage::put($fileName,$audio);
//        $this->audioFile = Storage::url($fileName);
//        dd($this->audioFile);
//    }
}
