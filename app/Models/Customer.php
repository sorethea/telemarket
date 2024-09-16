<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    //protected $primaryKey =['id','bot'];

    protected $fillable = [
        "first_name",
        "last_name",
        "name",
        "phone_number",
        "user_id",
        "channel",
        "is_subscribed",
    ];

    protected $appends = [
        "name"
    ];

    public function getNameAttribute(){
        return $this->first_name .' '.$this->last_name;
    }
    public function setNameAttribute(){
        $this->attributes['name']= $this->first_name .' '.$this->last_name;
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class,'chat_id','id');
    }

    public function telegrams(): BelongsToMany{
        return $this->belongsToMany(Telegram::class,'telegram_customers');
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
