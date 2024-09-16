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
        "customer_id",
        "customer_name",
        "bot",
        "type",
        "text",
        "file",
        "file_type",
        "chat",
        "message",
    ];

    protected $casts =[
        "chat_id"=>"string",
        "bot"=>"string",
        "type"=>"string",
        "text"=>"string",
        "chat"=>"array",
        "message"=>"array",
    ];

    public function customer(): BelongsTo{
        return $this->belongsTo(Customer::class);
    }
}
