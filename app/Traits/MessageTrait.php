<?php

namespace App\Traits;

use App\Models\Customer;
use App\Models\Message;

trait MessageTrait
{
    public function storeMessage($data){

    }
    public function store($bot,$update){
        $chat = $update->getChat();
        $msg = $update->getMessage();
        $chatId = $chat->getId();
        $chatType = $chat->get("type");
        $text = $msg->get('text');
        $message = new Message();
        $message->chat_id=$chatId;
        $message->type=$chatType;
        $message->text=$text;
        $message->bot=$bot;
        $message->message=$msg;
        $message->save();
        $customer = Customer::where('id',$chatId)
            ->where('channel','telegram')
            ->where('bot',$bot)->first();
        if(empty($customer)){
            $customer = new Customer();
            $customer->id=$chatId;
            $customer->channel = "telegram";
            $customer->bot = $bot;
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
}
