<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mockery\Exception;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        "chat_id",
        "bot",
        "type",
        "text",
        "message",
        "reply_to_text",
    ];

    protected $casts =[
        "chat_id"=>"string",
        "bot"=>"string",
        "type"=>"string",
        "text"=>"string",
        "message"=>"array",
    ];

    protected $appends =[
        "reply_to_text"
    ];
    public function customer(): BelongsTo{
        return $this->belongsTo(Customer::class,'chat_id','id');
    }

    public function getReplyToTextAttribute(): string
    {
        $text = "";
        try {
            $replyTo = $this->message["reply_to_message"]??"";
            $text = $replyTo["chat"]["text"];
        }catch (Exception $exception){
            logger($exception->getMessage());
        }


        return $text;
    }
}
