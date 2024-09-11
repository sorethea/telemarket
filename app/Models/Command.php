<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "text",
        "photos",
        "bot",
        "reply_markup"
    ];

    protected $casts =[
        "name"=>"string",
        "text"=>"string",
        "photos"=>"array",
        "reply_markup"=>"array",
        "bot"=>"string",
    ];
}
