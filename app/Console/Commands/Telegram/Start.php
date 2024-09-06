<?php

namespace App\Console\Commands\Telegram;

use App\Traits\MessageTrait;
use Illuminate\Support\Facades\Request;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class Start extends Command
{
    use MessageTrait;
    protected string $name = 'start';

    protected string $description = 'Start command for telegram bot.';

    public function handle(): void
    {
        $bot = Request::get('bot');
        $telegram = Telegram::bot($bot);
        $botName = config('telegram.bots.'.$bot.'.name');
        $botWebhookUrl = config('telegram.bots.'.$bot.'.webhook_url');
        $telegram->setWebhook(['url'=>$botWebhookUrl]);
        $this->replyWithMessage([
            'text' => __('command.start', ['bot'=>$botName]),
            'reply_markup'=>json_encode([
                'keyboard'=>[
                    [['text'=>'Subscript', "request_contact"=>true,'border'=>true]],

                ],
                'resize_keyboard' => true, // Optional
                'one_time_keyboard' => true, // Optional
                'selective_width' => false, // Optional
            ])
        ]);
        $this->store($bot,$telegram->getWebhookUpdate());
    }
}
