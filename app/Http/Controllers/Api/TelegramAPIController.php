<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Message;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramAPIController extends Controller
{
    public function webhook(){
        Telegram::commandsHandler(true);
        $update = Telegram::getWebhookUpdate();
        $chat = $update->getChat();
        $msg = $update->getMessage();
        $message = new Message();
        $message->chat_id = $chat->getId();
        $message->type = $chat->get("type");
        $message->text = $msg->get('text');
        $message->message = $msg;
        $message->save();
        $customer = Customer::where('channel_id',$chat->getId())->where('channel_name','telegram')->first();
        if(empty($customer)){
            $customer = new Customer();
            $customer->channel_id=$chat->getId();
            $customer->channel_name = "telegram";
            $customer->first_name=$chat->get('first_name');
            $customer->last_name=$chat->get('last_name');
            $customer->save();
        }
    }
}
