<?php

namespace App\Filament\Marketing\Resources;

use App\Filament\Marketing\Resources\MessageResource\Pages;
use App\Filament\Marketing\Resources\MessageResource\RelationManagers;
use App\Livewire\VoiceRecorder;
use App\Models\Customer;
use App\Models\Message;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class MessageResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'gmdi-mail';


    public static function getNavigationGroup(): string
    {
        return trans('market.nav.group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->label(trans('market.message.from')),
                Forms\Components\RichEditor::make("text")
                    ->label(trans('market.message.text')),
                Forms\Components\FileUpload::make("file")
                    ->disk("public")
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->label(trans('general.id'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label(trans('market.message.name'))
                    ->searchable(),
//                Tables\Columns\TextColumn::make("type")
//                    ->label(trans('general.type'))
//                    ->searchable()
//                    ->sortable(),
                Tables\Columns\TextColumn::make("message_type")
                    ->label(trans('general.type'))
                    ->formatStateUsing(fn($state)=>Str::ucfirst($state))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("text")
                    ->label(trans('market.message.content'))
                    ->getStateUsing(function ($record){
                        if(empty($record->text)){
                            return $record->file_name??$record->file;
                        }
                        return $record->text;
                    })
                    ->limit(35)
                    ->icon('heroicon-o-question-mark-circle')
                    ->iconPosition('after')
                    ->tooltip(fn($state)=>$state),
//                Tables\Columns\IconColumn::make('message.reply_to_message.text')
//                    ->toggleable()
//                    ->label(trans('market.message.reply_to'))
//                    ->icon('heroicon-o-question-mark-circle')
//                    ->iconPosition('after')
//                    ->tooltip(fn($state)=>$state),
                Tables\Columns\TextColumn::make('status')
                    ->label(trans('market.telegram.status.title'))
                    ->badge(),
                Tables\Columns\TextColumn::make("created_at")
                    ->toggleable()
                    ->label(trans('general.created_at'))
                    ->since()
                    ->sortable(),
            ])
            ->poll('10s')
            ->defaultSort('created_at', 'desc')
            ->filters([
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make("reply")
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->url(fn($record)=>"/messages/{$record->id}/reply"),


//                    Tables\Actions\Action::make("reply")
//                        ->icon('heroicon-o-arrow-uturn-left')
//                        ->form([
//                            Forms\Components\MarkdownEditor::make('text')
//                                ->required(fn($get)=>empty($get("file"))),
//                            Forms\Components\FileUpload::make('file')
//                                ->multiple()
//                                ->disk('public')
//                                ->acceptedFileTypes([
//                                    'image/jpg',
//                                    'image/npg',
//                                    'image/gif',
//                                    'audio/ogg',
//                                    'audio/oga',
//                                    'video/mpeg',
//                                    'video/mp4',
//                                    'application/pdf',
//                                    'application/zip',
//                                    'text/plain'
//                                ])
//                                ->directory(fn($record)=>$record->customer_id.'/sent')
//                                ->required(fn($get)=>empty($get("text"))),
////                            \App\Forms\Components\VoiceRecorder::make("voice")
////                                ->label("Voice Recorder")
////                                ->required(),
//                            Forms\Components\ViewField::make('voice-record')
//                                ->label("Voice Record")
//                                ->viewData(['chatId'=>static::getRecordRouteKeyName()])
//                                ->view('livewire.voice-recorder')
//                        ])
//                        ->action(function (array $data,$record){
//                            $telegram = Telegram::bot(auth()->user()->bot);
//                            if(!empty($text=$data['text'])){
//                                $telegram->sendMessage([
//                                    'chat_id'=>$record->customer_id,
//                                    'parse_mode'=>'markdown',
//                                    'text'=>$data['text']
//                                ]);
//                            }
//                            if(!empty($fileNames=$data["file"])){
//                                foreach ($fileNames as $fileName){
//                                    $fileNameArray = explode(".",$fileName);
//                                    $extension = end($fileNameArray);
//                                    $file = InputFile::create('storage/'.$fileName);
//                                    switch ($extension){
//                                        case 'jpg':
//                                        case 'png':
//                                        case 'gif':
//                                            $telegram->sendPhoto([
//                                                'chat_id'=>$record->customer_id,
//                                                'photo'=>$file,
//                                            ]);
//                                            break;
//                                        case 'mp4':
//                                            $telegram->sendVideo([
//                                                'chat_id'=>$record->customer_id,
//                                                'video'=>$file,
//                                            ]);
//                                            break;
//                                        case 'ogg':
//                                        case 'oga':
//                                            $telegram->sendVoice([
//                                                'chat_id'=>$record->customer_id,
//                                                'voice'=>$file,
//                                            ]);
//                                            break;
//                                        default:
//                                            $telegram->sendDocument([
//                                                'chat_id'=>$record->customer_id,
//                                                'document'=>$file,
//                                            ]);
//                                    }
//                                }
//
//
//                            }
//
//                        })
//                        ->modalSubmitActionLabel(trans('market.telegram.send')),
                    Tables\Actions\Action::make("forward")
                        ->icon('heroicon-o-arrow-uturn-right')
                        ->form([
                            Forms\Components\Select::make('customer')
                                ->label(trans('market.telegram.send_to'))
                                ->options(fn()=>Customer::where("bot",auth()->user()->bot)->where("is_forward",true)->pluck("name","id"))
                                ->multiple(),
                        ])
                        ->modalSubmitActionLabel(trans('market.telegram.send')),
               ]),

//                Tables\Actions\EditAction::make(),
//                \Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction::make('media')
//                    ->visible(fn($record):bool=>$record->is_media)
//                    ->media(fn($record)=>Storage::url($record->file))
//                    ->icon('heroicon-o-eye'),
//                Tables\Actions\Action::make("download")
//                    ->visible(fn($record):bool=>$record->is_download)
//                    ->url(fn($record):string=>Storage::url($record->file))
//                    ->openUrlInNewTab()
//                    ->icon('heroicon-o-arrow-down-tray'),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
            'reply' => Pages\ReplyMessage::route('/{record}/reply'),
            'view' => Pages\ViewMessage::route('/{record}'),
//            'create' => Pages\CreateMessage::route('/create'),
            //'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }



    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
}
