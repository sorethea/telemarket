<?php

namespace App\Console\Commands\Telegram;

use Illuminate\Support\Facades\Request;
use Telegram\Bot\Commands\Command;

class Start extends Command
{
    protected string $name = 'start';

    protected string $description = 'Start command for telegram bot.';

    public function handle(): void
    {

        $botKey = Request::get('bot');
        $bot = config('telegram.bots.'.$botKey.'.name');
        $this->replyWithMessage([
            'text' => __('command.start', ['bot'=>$bot]),
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>'Subscribe', 'type'=>'button', "request_contact"=>true]],
                ],
//                'keyboard'=>[
//                    [['text'=>'Subscript','callback_data'=>'subscript', "request_contact"=>true,'border'=>true]],
//
//                ],
                'resize_keyboard' => true, // Optional
                'one_time_keyboard' => true, // Optional
                'selective_width' => false, // Optional
            ])
        ]);
    }
}
