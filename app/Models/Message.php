<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        "chat_id",
        "type",
        "first_name",
        "last_name",
        "text",
        "files",
        "location",
        "contact",
        "message",
    ];

    protected $casts =[
        "chat_id"=>"string",
        "type"=>"string",
        "first_name"=>"string",
        "last_name"=>"string",
        "text"=>"string",
        "files"=>"array",
        "location"=>"array",
        "contact"=>"array",
        "message"=>"array",
    ];
}
