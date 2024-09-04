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
        $message->message = $msg;
        $message->save();
        $from = $update->get('from');
        $customer = Customer::where('telegram_id',$from->get('id'))->first();
        if(empty($customer)){
            $customer = new Customer();
            $customer->telegram_id=$from->get('id');
            $customer->first_name=$from->get('first_name');
            $customer->last_name=$from->get('last_name');
            $customer->save();
        }
    }
}
