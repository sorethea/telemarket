<?php

namespace App\Http\Controllers;

use App\Models\Telegram;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function send(Telegram $telegram){
        $sendTo = $telegram->send_to;
        if(!empty($sendTo)){
            foreach ($sendTo as $customer){

            }
        }
    }
}
