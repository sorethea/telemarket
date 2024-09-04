<?php

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('bot/webhook', function (){
    return Telegram::setWebhook(['url' => 'https://tele.hieatapps.com/api/{token}/webhook']);
});
Route::post('/{token}/webhook', [\App\Http\Controllers\Api\TelegramAPIController::class,'webhook']);
