<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//Route::post('bot/webhook', function (){
//    foreach (config('telegram.bots') as $key => $bot){
//        Telegram::bot($key)->setWebhook(['url' => 'https://tele.hieatapps.com/api/{token}/webhook?bot='.$key]);
//    }
//});
Route::post('/{token}/webhook', [\App\Http\Controllers\Api\TelegramAPIController::class,'webhook']);
Route::post('/telegram/send', [\App\Http\Controllers\Api\TelegramAPIController::class,'send']);
Route::post('/telegram/send-photo', [\App\Http\Controllers\Api\TelegramAPIController::class,'sendPhoto']);
Route::post('/telegram/send-voice', [\App\Http\Controllers\Api\TelegramAPIController::class,'sendVoice']);

//Route::post('/voice',function (Request $request){
//    $path = $request->file('audio')->store('audio','public');
//    $bot=auth()->user()->bot??config('telegram.default');
//    $telegram = \Telegram\Bot\Laravel\Facades\Telegram::bot($bot);
//
//    $telegram->sendMessage([
//        'chat_id'=>1819705661,
//        'voice'=>"Voice record stored.",
//    ]);
//});
