<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "content",
        "photos",
        "user_id",
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}
