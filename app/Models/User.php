<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'require_follow_approval',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'following_id',
            'follower_id'
        );
    }

    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'follow',
            'follower_id',
            'following_id',
        );
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function taggedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_tags');
    }

    public function groups()
    {
        return $this->hasManyThrough(Group::class, GroupMember::class, 'user_id', 'id', 'id', 'group_id');
    }

    public function favoritePosts()
    {
    return $this->belongsToMany(Post::class, 'favorites');
    }

    public function reposts()
    {
    return $this->hasMany(Repost::class);
    }

    public function stories()
    {
    return $this->hasMany(Story::class);
    }
}