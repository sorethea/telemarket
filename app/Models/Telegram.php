<?php

namespace App\Models;

use App\Options\Status;
use App\Options\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telegram extends Model
{
    use HasFactory, SoftDeletes;

    public function getSendToTotalAttribute(){
        return count($this->send_to);
    }
    protected $fillable = [
        "bot",
        "type",
        "title",
        "content",
        "photos",
        "send_to",
        "send_to_total",
        "sent_cycle",
        "sent_count",
        "user_id",
        "status",
    ];
    protected $appends = [
        "send_to_total",
    ];
    protected $casts = [
        "bot"=>"string",
        "type"=>Type::class,
        "title"=>"string",
        "content"=>"string",
        "photos"=>"array",
        "send_cycle"=>"integer",
        "send_count"=>"integer",
        "send_to"=>"array",
        "user_id"=>"integer",
        "status"=>Status::class,
    ];
    public function customers(): BelongsToMany{
        return $this->belongsToMany(Customer::class,'telegram_customers');
    }
}
