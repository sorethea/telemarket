<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telegram extends Model
{
    use HasFactory;
    protected $fillable = [
        "bot",
        "type",
        "title",
        "content",
        "photos",
        "send_to",
        "user_id",
        "status",
    ];

    protected $casts = [
        "bot"=>"string",
        "type"=>"string",
        "title"=>"string",
        "content"=>"string",
        "photos"=>"array",
        "send_to"=>"array",
        "user_id"=>"integer",
        "status"=>"string",
    ];
}
