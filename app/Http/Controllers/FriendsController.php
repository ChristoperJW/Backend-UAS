<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;

class FriendsController extends Controller
{
    public function index()
    {
        $currentUserId = 1;

        $followedUsers = Follow::where('follower_id', $currentUserId)
            ->pluck('following_id');

        $suggestions = User::where('id', '!=', $currentUserId)
            ->whereNotIn('id', $followedUsers)
            ->inRandomOrder()
            ->take(5)
            ->get();

        $followersCount = Follow::where('following_id', $currentUserId)
            ->count();

        $followingCount = Follow::where('follower_id', $currentUserId)
            ->count();

        return view('friends.index', compact(
            'suggestions',
            'followersCount',
            'followingCount'
        ));
    }
}
