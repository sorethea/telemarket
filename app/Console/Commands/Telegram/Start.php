<?php

namespace App\Console\Commands\Telegram;

use Telegram\Bot\Commands\Command;

class Start extends Command
{
    protected string $name = 'start';

    protected string $description = 'Start command for telegram bot.';

    public function handle(): void
    {
        $this->replyWithMessage([
            'text' => __('command.start'),
            'reply_markup'=>json_encode([
                'keyboard'=>[
                    [['text'=>'Subscript','callback_data'=>'subscript', "request_contact"=>true,'border'=>true]],

                ],
                'resize_keyboard' => true, // Optional
                'one_time_keyboard' => true, // Optional
                'selective_width' => false, // Optional
            ])
        ]);
    }
}
