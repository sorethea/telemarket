<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function customer(): BelongsTo{
        return $this->belongsTo(Customer::class,'chat_id','id');
    }
}
