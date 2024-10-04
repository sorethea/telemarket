<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Telegram\Bot\FileUpload\InputFile;
use function Laravel\Prompts\error;

trait Telegram
{
    public static function sendToTelegram(\App\Models\Telegram $telegram): void
    {
        $sendTo = $telegram->send_to;
        $content = $telegram->content;
        $photos = $telegram->photos;
        $bot = $telegram->bot;
        $telegramBot = \Telegram\Bot\Laravel\Facades\Telegram::bot($bot);
        if(!empty($sendTo)){
            foreach ($sendTo as $chatId){
                if(!empty($photos) || !empty($content)){
                    if(!empty($photos)){
                        foreach ($photos as $photo){
                            if(file_exists('storage/'.$photo)){
                                $photoArray = explode(".",$photo);
                                $extension = end($photoArray);
                                try {

                                        $file = InputFile::create('storage/'.$photo,$photo);
                                        switch ($extension){
                                            case 'jpg':
                                            case 'npg':
                                            case 'gif':
                                                $telegramBot->sendPhoto([
                                                    'chat_id'=>$chatId,
                                                    'photo'=>$file,
                                                ]);
                                            case 'mp4':
                                            case 'mpeg':
                                                $telegramBot->sendPhoto([
                                                    'chat_id'=>$chatId,
                                                    'video'=>$file,
                                                ]);
                                            case 'ogg':
                                            case 'oga':
                                                $telegramBot->sendVoice([
                                                    'chat_id'=>$chatId,
                                                    'voice'=>$file,
                                                ]);
                                            default:
                                                $telegramBot->sendPhoto([
                                                    'chat_id'=>$chatId,
                                                    'voice'=>$file,
                                                ]);
                                    }
                                }catch (\Exception $exception){
                                    error($exception->getMessage());
                                }

                            }


                        }
                    }
                    if(!empty($content)){
                        $telegramBot->sendMessage([
                            'chat_id'=>$chatId,
                            'text'=>$content,
                        ]);
                    }
                    $telegram->sent_count +=1;
                }
                }
            $telegram->status = "sent";
            $telegram->sent_cycle +=1;
            $telegram->save();

        }
    }
}
