<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\User;
use App\Models\Like;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'is_published',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
    
    public function likes(){
        return $this->hasMany(Like::class);
    }
    
}
