<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mockery\Exception;
use function Laravel\Prompts\error;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        "chat_id",
        "bot",
        "type",
        "text",
        "from",
        "message",
        "reply_to_text",
    ];

    protected $casts =[
        "chat_id"=>"string",
        "bot"=>"string",
        "type"=>"string",
        "text"=>"string",
        "from"=>"array",
        "message"=>"array",
    ];

    protected $appends =[
        "reply_to_text",
        "from",
    ];
    public function customer(): BelongsTo{
        return $this->belongsTo(Customer::class,'chat_id','id');
    }

    public function getReplyToTextAttribute(): string
    {
        $text = "";
        try {
            $replyTo = $this->message["reply_to_message"]??"";
            if(!empty($replyTo)){
                $text = $replyTo["text"];
            }

        }catch (Exception $exception){
            error($exception->getMessage());
        }

        return $text;
    }
    public function getFromAttribute(): array
    {
        $from = [];
        try {
            $from = $this->message["from"]??[];

        }catch (Exception $exception){
            error($exception->getMessage());
        }

        return $from;
    }
}
