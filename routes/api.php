<?php

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('bot/webhook', function (){
//    foreach (config('telegram.bots') as $key => $bot){
//        $telegram =Telegram::bot($key)->setWebhook(['url' => 'https://tele.onekhmer.com/api/{token}/webhook?bot='.$key]);
//    }
    $telegram =Telegram::bot('thea');
    $telegram->setWebhook(['url' => 'https://tele.onekhmer.com/api/{token}/webhook' ]);
    $telegram->getWebhookUpdate(true);
    return $telegram->getMe();
});
Route::post('/{token}/webhook', [\App\Http\Controllers\Api\TelegramAPIController::class,'webhook']);
Route::post('/telegram/send', [\App\Http\Controllers\Api\TelegramAPIController::class,'send']);
Route::post('/telegram/send-photo', [\App\Http\Controllers\Api\TelegramAPIController::class,'sendPhoto']);
