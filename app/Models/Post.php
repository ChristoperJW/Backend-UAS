<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [ 'user_id', 'caption', 'media'];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function taggedUsers()
    {
        return $this->belongsToMany(User::class, 'post_user_tags');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
