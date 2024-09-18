<?php

namespace App\Traits;

use App\Models\Customer;
use App\Models\Message;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function Laravel\Prompts\error;

trait MessageTrait
{
    public function store($bot,$update){
        if(empty($bot))$bot=config('telegram.default');
        $chat = $update->getChat();
        $msg = $update->getMessage();
        $chatId = $chat->getId();
        $telegram = \Telegram\Bot\Laravel\Facades\Telegram::bot($bot);
        $fileName = '';
        $saveFileName = '';
        $fileType = '';
        $is_media = false;
        $is_download = false;
        $message_type = "text";
        if (!empty($msg->get("contact")))$message_type="contact";
        if (!empty($msg->get("location")))$message_type="location";
        if(!empty($document=$msg->get("document"))){
            $file = $telegram->getFile(['file_id'=>$document->file_id]);
            $fileName = $document->file_name;
            $fileType = $document->mime_type;
            $saveFileName =$this->saveTelegramFile($bot,$file);
            $is_download = true;
            $message_type="document";
        }
        if(!empty($voice=$msg->get("voice"))){
            $file = $telegram->getFile(['file_id'=>$voice->file_id]);
            $fileType = $voice->mime_type;
            $saveFileName =$this->saveTelegramFile($bot,$file);
            $is_media = true;
            $message_type = "voice";
        }
        if(!empty($video=$msg->get("video"))){
            $file = $telegram->getFile(['file_id'=>$video->file_id]);
            $fileType = $video->mime_type;
            $saveFileName =$this->saveTelegramFile($bot,$file);
            $is_media = true;
            $message_type = "video";
        }
        if(!empty($photos=$msg->get("photo"))){
            $i = 1;
            $n = count($photos);
            foreach ($photos as $photo){
                if($i==$n){
                    $file = $telegram->getFile(['file_id'=>$photo->file_id]);
                    $saveFileName =$this->saveTelegramFile($bot,$file);
                }
                $i++;
            }
            $is_media =true;
            $message_type ="photo";
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
        $message->file_name=$fileName;
        $message->file_type=$fileType;
        $message->bot=$bot;
        $message->chat=$chat;
        $message->is_media=$is_media;
        $message->is_download=$is_download;
        $message->from=$msg->get("from");
        $message->contact=$msg->get("contact");
        $message->location=$msg->get("location");
        $message->document=$msg->get("document");
        $message->voice=$msg->get("voice");
        $message->video=$msg->get("video");
        $message->photo=$msg->get("photo");
        $message->message=$msg;
        $message->message_type=$message_type;
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

    public function saveTelegramFile($bot,$file) {
        try {
            $token = config("telegram.bots.{$bot}.token");
            $filePath = $file->getFilePath();
            $filePathArray = explode("/",$filePath);
            if(count($filePathArray)>1){
                $fileName = end($filePathArray);
            }else{
                $fileName = $filePath;
            }
            $fileNameArray = explode(".",$fileName);
            $fileExtension = end($fileNameArray);
            if($fileExtension=="oga")$fileExtension="ogg";
            $fileName = Str::random(36).".".$fileExtension;
            Storage::put("public/{$fileName}",file_get_contents("https://api.telegram.org/file/bot{$token}/{$filePath}"));
            return $fileName;
        }catch (\Exception $exception){
            error($exception->getMessage());
        }
    }
}
