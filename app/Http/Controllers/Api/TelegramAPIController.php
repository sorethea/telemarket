<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Message;
use App\Models\ReplyMessage;
use App\Models\User;
use App\Traits\MessageTrait;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe\DataMapping\Format;
use FFMpeg\Format\AudioInterface;
use FFMpeg\Format\FormatInterface;
use FFMpeg\Format\FormatInterface as FormatInterfaceAlias;
use FFMpeg\Format\Video\Ogg;
use FFMpeg\Format\Video\WebM;
use FFMpeg\Media\MediaTypeInterface;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        Notification::make()
            ->title("Received new telegram message!")
            ->sendToDatabase(User::all());
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
    public function saveVoice(Request $request){
        $path = $request->file('audio')->store('audio','public');
        $ffmpeg = FFMpeg::create();
        $audioFile = $ffmpeg->open(storage_path("app/public/".$path));
        $formatOgg = new Ogg();
        $formatOgg->on('progress',function (MediaTypeInterface $audio,AudioInterface $format,float $percentage){
            printf(
                "Transcoded %s percent of %s using the %s codec.\n",
                $percentage,
                basename($audio->getPathfile()),
                $format->getAudioCodec(),
            );
        });
        $audioFileName = Str::random(16)."ogg";
        $audioFile->save($formatOgg,storage_path($audioFileName));
        $customerId = $request->get('customer_id');
        $replyMessage = new ReplyMessage();
        $replyMessage->customer_id = $customerId;
        $replyMessage->status = "draft";
        $replyMessage->file = $audioFileName;
        $replyMessage->type = "voice";
        $replyMessage->save();

    }
}
