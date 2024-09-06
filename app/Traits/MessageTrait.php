<?php

namespace App\Traits;

use App\Models\Customer;
use App\Models\Message;

trait MessageTrait
{
    public function store($bot,$update){
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
            ->where('bot',$bot)->first();
        if(empty($customer)){
            $customer = new Customer();
            $customer->id=$chat->getId();
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
