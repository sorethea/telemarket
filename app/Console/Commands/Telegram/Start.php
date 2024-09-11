<?php

namespace App\Console\Commands\Telegram;

use App\Models\Post;
use App\Traits\MessageTrait;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Button;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class Start extends Command
{
    use MessageTrait;
    protected string $name = 'start';

    protected string $description = 'Start command for telegram bot.';

    public function handle(): void
    {
        $bot = Request::get('bot',config('telegram.default'));
        $telegram = Telegram::bot($bot);
        $botName = config('telegram.bots.'.$bot.'.name');
        $botWebhookUrl = config('telegram.bots.'.$bot.'.webhook_url');
        $telegram->setWebhook(['url'=>$botWebhookUrl]);
        $startCommandObj = \App\Models\Command::query()->where('name','start')->where('bot',$bot)->first();
        if(!empty($photos = $startCommandObj->photos)){
            foreach ($photos as $photo){
                $this->replyWithPhoto([
                    "photo"=>InputFile::create('storage/'.$photo),
                ]);
            }
        }
        $replyMarkup = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::button([
                    'text'=>'Booking',
                    'url'=>'https://tele.hieatapps.com'
                ])
            ])
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);
        if(!empty($startCommandObj->text)){
            $this->replyWithMessage([
                'text' => $startCommandObj->text,
                //'reply_markup'=>File::get('storage/'.$startCommandObj->reply_markup),
                'reply_markup'=>$replyMarkup,
            ]);
        }

    }
}
