<?php

namespace App\Console\Commands\Telegram;

use App\Models\Post;
use App\Traits\MessageTrait;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Request;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\FileUpload\InputFile;
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
        $posts = Post::query()->limit(3)->get();
        foreach ($posts as $post){
            $this->replyWithPhoto([
                "photo"=>InputFile::create("storage/".$post->photos)
            ]);
        }
        $this->replyWithMessage([
            'text' => __('command.start', ['bot'=>$botName]),
            'reply_markup'=>json_encode([
                'keyboard'=>[
                    [['text'=>'Subscribe', "request_contact"=>true,'border'=>true]],

                ],
                'resize_keyboard' => true, // Optional
                'one_time_keyboard' => true, // Optional
                'selective_width' => false, // Optional
            ])
        ]);
    }
}
