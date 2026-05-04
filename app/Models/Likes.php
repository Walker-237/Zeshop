<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $fillable = [
        "user_id",
        "post_id"
    ];

    public function userLike(){
        return $this->belongsTo(user::class);
    }

    public function postLike(){
        return $this->belongsTo(post::class);
    }

    public function Like(){
        return $this->hasMany(post::class);
    }
}
