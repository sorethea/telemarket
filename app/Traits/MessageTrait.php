<?php

namespace App\Traits;

use App\Models\Customer;
use App\Models\Message;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\error;

trait MessageTrait
{
    public function store($bot,$update){
        if(empty($bot))$bot=config('telegram.default');
        $chat = $update->getChat();
        $msg = $update->getMessage();
        $chatId = $chat->getId();
        $telegram = \Telegram\Bot\Laravel\Facades\Telegram::bot($bot);
        $saveFileName = '';
        $fileType = '';
        if(!empty($doucment=$msg->get("document"))){
            $file = $telegram->getFile(['file_id'=>$doucment->file_id]);
            $fileName = $doucment->file_name;
            $fileType = $doucment->mime_type;
            $directory = "document";
            $saveFileName =$this->saveTelegramFile($bot,$file,$fileName,$directory);
        }

        $name = $chat->get("first_name")." ".$chat->get("last_name");
        $chatType = $chat->get("type");
        $text = $msg->get('text');
        $message = new Message();
        $message->customer_id=$chatId;
        $message->customer_name=$name;
        $message->type=$chatType;
        $message->text=$text;
        $message->file=$saveFileName;
        $message->file_type=$fileType;
        $message->bot=$bot;
        $message->chat=$chat;
        $message->from=$msg->get("from");
        $message->contact=$msg->get("contact");
        $message->location=$msg->get("location");
        $message->document=$msg->get("document");
        $message->voice=$msg->get("voice");
        $message->video=$msg->get("video");
        $message->photo=$msg->get("photo");
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

    public function saveTelegramFile($bot,$file,$fileName,$directory) {
        try {
            $token = config("telegram.bots.ichiban.token");
            $filePath = $file->getFilePath();
            $fileLocation = $directory."/".$fileName;
            Storage::put($fileLocation,file_get_contents("https://api.telegram.org/file/bot{$token}/{$filePath}"));
            return $fileLocation;
        }catch (\Exception $exception){
            error($exception->getMessage());
        }
    }
}
