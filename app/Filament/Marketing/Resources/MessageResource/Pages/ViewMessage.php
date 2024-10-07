<?php

namespace App\Filament\Marketing\Resources\MessageResource\Pages;

use App\Filament\Marketing\Resources\MessageResource;

use App\Models\Message;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class ViewMessage extends ViewRecord
{
    protected static string $resource = MessageResource::class;

    public bool $showRecord = true;
    public bool $showStop = false;

    public int $customerId;

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $message =Message::find($record);

        $this->customerId = $message->customer_id;
    }

    public function voiceRecord(): void
    {
        $this->dispatch('voiceRecordStart',['message'=>"This is a dispatch."]);
        $this->showStop = true;
    }

    public function voiceStop(): void
    {
        $this->dispatch('voiceRecordStop',['message'=>"This is a dispatch."]);
        $this->showStop = false;
    }

    protected function getHeaderActions(): array
    {
        return[
            Action::make("text-reply")
                ->form([
                    MarkdownEditor::make("text")
                        ->label(trans("market.message.content"))
                        ->required(),
                ])
                ->hiddenLabel(true)
                ->icon('heroicon-o-chat-bubble-oval-left-ellipsis')
                ->tooltip(trans('market.message.voice_reply'))
                ->modalSubmitActionLabel('Reply')
                ->action(function ($data){
                    $telegram = Telegram::bot($this->record->bot);
                    $telegram->sendMessage([
                        'chat_id'=>$this->record->customer_id,
                        'text'=>$data["text"],
                    ]);
                    $replyMessage = new \App\Models\ReplyMessage();
                    $replyMessage->status="sent";
                    $replyMessage->type="text";
                    $replyMessage->text=$data["text"];
                    $this->record->customer->replyMessages()->save($replyMessage);
                })
                ->modal(),

            Action::make("file-reply")
                ->form([
                    FileUpload::make("files")
                        ->multiple()
                        ->label(trans("market.message.file"))
                        ->required(),
                ])
                ->hiddenLabel(true)
                ->icon('heroicon-o-paper-clip')
                ->tooltip(trans('market.message.voice_reply'))
                ->modalSubmitActionLabel('Reply')
                ->action(function ($data){
                    $telegram = Telegram::bot($this->record->bot);
                    $files = $data["files"];
                    foreach ($files as $file){
                        $telegram->sendDocument([
                            'chat_id'=>$this->record->customer_id,
                            'document'=>InputFile::create("storage/".$file),
                        ]);
                        $replyMessage = new \App\Models\ReplyMessage();
                        $replyMessage->status="sent";
                        $replyMessage->type="document";
                        $replyMessage->file=$file;
                        $this->record->customer->replyMessages()->save($replyMessage);
                    }
                })
                ->modal(),
            Action::make("voice-reply")
                ->form([
                    ViewField::make('voice-reply')
                        ->view("livewire.voice-reply")
                ])
                ->hiddenLabel(true)
                ->icon('heroicon-o-microphone')
                ->tooltip(trans('market.message.voice_reply'))
                ->modalSubmitActionLabel('Reply')
                ->action(function ($record){
                    $record->customer->replyMessages->where("type","voice")->where("status","draft")->each( function ($reply) use($record){
                        $telegram = Telegram::bot($record->bot);
                        $telegram->sendVoice([
                            'chat_id'=>$record->customer_id,
                            'voice'=>InputFile::create('storage/'.$reply->file),
                        ]);
                        $reply->status = "sent";
                        $reply->save();
                    });
                    return redirect(request()->header('Referer'));
                })
                ->modal(),

        ];
    }
}
