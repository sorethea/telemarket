<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramAPIController extends Controller
{
    public function webhook(Request $request){
        $bot = $request->get('bot');
        $telegram = Telegram::bot($bot);
        $telegram->commandsHandler(true);
        $update = $telegram->getWebhookUpdate();
        $chat = $update->getChat();
        $msg = $update->getMessage();
        $message = new Message();
        $message->chat_id = $chat->getId();
        $message->type = $chat->get("type");
        $message->text = $msg->get('text');
        $message->message = $msg;
        $message->bot = $bot;
        $message->save();
        $customer = Customer::where('id',$chat->getId())
            ->where('channel','telegram')
            ->where('bot',$request->get('bot'))->first();
        if(empty($customer)){
            $customer = new Customer();
            $customer->id=$chat->getId();
            $customer->channel = "telegram";
            $customer->bot = $request->get('bot');
            $customer->first_name=$chat->get('first_name');
            $customer->last_name=$chat->get('last_name');
            $customer->save();
        }
        $contact = $msg->get('contact');
        if(!empty($contact)){
            $customer->phone_number = $contact->get('phone_number');
            $customer->is_subscribed = true;
            $customer->save();

        }
    }

    public function send(Request $request){
        $bot = $request->get("bot");
        if(!empty($bot)){
            $telegram = Telegram::bot($bot);
            $telegram->setWebhook(config('telegram.bots.'.$bot.'.webhook_url'));
            $telegram->sendMessage([
                'chat_id'=>$request->get('chat_id'),
                'text'=>$request->get('text'),
            ]);
        }

    }

    public function sendPhoto(Request $request){
        $bot = $request->get('bot');
        $telegram = Telegram::bot($bot);
        //$telegram->sendPhoto();

    }
}
