<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;

class FriendsController extends Controller
{
    public function index()
    {
        $currentUserId = session('current_user_id', 1);

        $currentUser = User::find($currentUserId);

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

        $allUsers = User::all();

        return view('friends.index', compact(
            'suggestions',
            'followersCount',
            'followingCount',
            'allUsers',
            'currentUser'
        ));
    }

    public function switchUser($id)
    {
        session(['current_user_id' => $id]);
        return redirect('/friends');
    }

    public function followers()
    {
        $currentUserId = session('current_user_id', 1);

        $followers = User::where('id', function ($query) use ($currentUserId) {

            $query->select('follower_id')
                ->from('follows')
                ->where('following_id', $currentUserId);
        })->get();

        return view('friends.followers', compact('followers'));
    }

    public function following()
    {
        $currentUserId = session('current_user_id', 1);

        $followingIds = Follow::where('follower_id', $currentUserId)
                ->pluck('following_id');

        $followingUsers = User::whereIn('id', $followingIds)->get();

        return view('friends.following', compact('followingUsers'));
    }
}