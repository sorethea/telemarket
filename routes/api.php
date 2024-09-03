<?php

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/{token}/webhook', function () {
    Telegram::commandsHandler(true);
    $update = Telegram::getWebhookUpdate();
    $chat = $update->getChat();
    $msg = $update->getMessage();
    $message = new Message();
    $message->chat_id = $chat->getId();
    $message->type = $chat->get("type");
    $message->title = $chat->get("title");
    $message->first_name = $chat->get('first_name');
    $message->last_name = $chat->get('last_name');
    $message->text = $msg->get('text');
    $message->location = $msg->get('location');
    $message->contact = $msg->get('contact');
    $message->message = $msg;
    $message->save();
    return 'ok';
});
