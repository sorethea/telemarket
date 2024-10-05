<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        "phone_number",
        "first_name",
        "last_name",
        "gender",
        "date_of_birth",
        "blood_group",
        "email",
        "address",
        "city",
        "country",
        "personal_history",
        "medical_history",
        "other",
    ];

    protected $casts = [
        "phone_number"=>"string",
        "first_name"=>"string",
        "last_name"=>"string",
        "gender"=>"string",
        "date_of_birth"=>"date",
        "blood_group"=>"string",
        "email"=>"string",
        "address"=>"string",
        "city"=>"string",
        "country"=>"string",
        "personal_history"=>"json",
        "medical_history"=>"json",
        "other",
    ];
}
