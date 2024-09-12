<?php

namespace App\Traits;

use Telegram\Bot\FileUpload\InputFile;

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
                            $photoFile = InputFile::create('storage/'.$photo);
                            $telegramBot->sendPhoto([
                                'chat_id'=>$chatId,
                                'photo'=>$photoFile,
                            ]);
                        }
                    }
                    if(!empty($content)){
                        $telegramBot->sendMessage([
                            'chat_id'=>$chatId,
                            'text'=>$content,
                        ]);
                    }
                }

                }
            $telegram->status = "sent";
            $telegram->sent +=1;
            $telegram->save();

        }
    }
}
