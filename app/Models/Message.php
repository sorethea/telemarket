<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        "chat_id",
        "bot",
        "type",
        "text",
        "message",
    ];

    protected $casts =[
        "chat_id"=>"string",
        "bot"=>"string",
        "type"=>"string",
        "text"=>"string",
        "message"=>"array",
    ];
}
