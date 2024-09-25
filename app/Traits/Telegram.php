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
                            if(!empty($photo)){
                                $photoArray = explode(".",$photo);
                                $extension = end($photoArray);
                                try {
                                    logger('storage/'.$photo);
                                    if(file_exists('storage/'.$photo)){
                                        $photoFile = InputFile::create('storage/'.$photo,$photo);
                                        switch ($extension){
                                            case 'jpg':
                                            case 'npg':
                                            case 'gif':
                                                $telegramBot->sendPhoto([
                                                    'chat_id'=>$chatId,
                                                    'photo'=>$photoFile,
                                                ]);
                                            case 'mp4':
                                            case 'mpeg':
                                                $telegramBot->sendPhoto([
                                                    'chat_id'=>$chatId,
                                                    'video'=>$photoFile,
                                                ]);
                                            case 'ogg':
                                            case 'oga':
                                                $telegramBot->sendPhoto([
                                                    'chat_id'=>$chatId,
                                                    'voice'=>$photoFile,
                                                ]);
                                            default:
                                                $telegramBot->sendPhoto([
                                                    'chat_id'=>$chatId,
                                                    'voice'=>$photoFile,
                                                ]);
                                    }
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
