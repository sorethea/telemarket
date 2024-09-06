<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    //protected $primaryKey =['id','bot'];

    protected $fillable = [
        "first_name",
        "last_name",
        "phone_number",
        "user_id",
        "channel",
        "is_subscript",
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class,['id','bot'],['chat_id','bot']);
    }

}
