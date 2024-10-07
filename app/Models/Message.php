<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery\Exception;
use function Laravel\Prompts\error;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        "customer_id",
        "customer_name",
        "bot",
        "type",
        "file",
        "file_type",
        "caption",
        "text",
        "from",
        "photo",
        "chat",
        "contact",
        "location",
        "document",
        "voice",
        "video",
        "message",
    ];

    protected $casts =[
        "chat_id"=>"string",
        "bot"=>"string",
        "type"=>"string",
        "caption"=>"string",
        "text"=>"string",
        "photo"=>"array",
        "from"=>"array",
        "chat"=>"array",
        "contact"=>"array",
        "location"=>"array",
        "document"=>"array",
        "voice"=>"array",
        "video"=>"array",
        "message"=>"array",
    ];

    public function customer(): BelongsTo{
        return $this->belongsTo(Customer::class);
    }

    public function replyMessages(): HasMany{
        return $this->hasMany(ReplyMessage::class);
    }
}
