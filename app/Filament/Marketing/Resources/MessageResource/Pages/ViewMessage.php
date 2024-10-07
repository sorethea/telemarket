<?php

namespace App\Filament\Marketing\Resources\MessageResource\Pages;

use App\Filament\Marketing\Resources\MessageResource;

use Filament\Actions;
use Filament\Actions\Action;
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

    public int $messageId;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->messageId = $record;
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
                    $this->record->replyMessage()->save($replyMessage);
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
                    $record->replyMessages->where("type","voice")->where("status","draft")->each( function ($reply) use($record){
                        $telegram = Telegram::bot($record->bot);
                        $telegram->sendVoice([
                            'chat_id'=>$record->customer_id,
                            'voice'=>InputFile::create('storage/'.$reply->file),
                        ]);
                        $reply->status = "sent";
                        $reply->save();
                    });
                })
                ->modal(),

        ];
    }
}
