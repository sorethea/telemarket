<?php

namespace App\Models;

use App\Options\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telegram extends Model
{
    use HasFactory, SoftDeletes;
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
        "status"=>Status::class,
    ];
}
