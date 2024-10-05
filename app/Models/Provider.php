<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory;

    protected $fillable =[
        "user_id",
        "department_id",
        "phone_number",
        "first_name",
        "last_name",
        "gender",
        "date_of_birth",
        "email",
        "address",
        "city",
        "country",
    ];
    protected $casts = [
        "phone_number"=>"string",
        "first_name"=>"string",
        "last_name"=>"string",
        "gender"=>"string",
        "date_of_birth"=>"date",
        "email"=>"string",
        "address"=>"string",
        "city"=>"string",
        "country"=>"string",
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function encounters():HasMany
    {
        return $this->hasMany(PatientEncounter::class);
    }
}
