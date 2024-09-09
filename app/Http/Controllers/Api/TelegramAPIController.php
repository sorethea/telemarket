<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Message;
use App\Traits\MessageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramAPIController extends Controller
{
    use MessageTrait;
    public function webhook(Request $request){
        $bot = $request->get('bot');
        $telegram = Telegram::bot($bot);
        $telegram->commandsHandler(true);
        $update = $telegram->getWebhookUpdate();
        $this->store($bot,$update);
    }
    public function send(Request $request){
        $bot = $request->get("bot");
        if(!empty($bot)){
            $telegram = Telegram::bot($bot);
            $telegram->sendMessage([
                'chat_id'=>$request->get('chat_id'),
                'text'=>$request->get('text'),
            ]);
        }

    }

    public function sendPhoto(Request $request){
        $bot = $request->get('bot');
        $telegram = Telegram::bot($bot);
        $telegram->sendPhoto([
            'chat_id'=>$request->get('chat_id'),
            'photo'=>InputFile::create($request->get('photo')),
            //'caption'=>$request->get('caption'),
        ]);

    }
}
