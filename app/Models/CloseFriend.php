<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CloseFriend extends Model
{
    protected $fillable = [
        'user_id',
        'close_friend_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function closeFriend()
    {
        return $this->belongsTo(User::class, 'close_friend_id');
    }
}
