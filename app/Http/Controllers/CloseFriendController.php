<?php

namespace App\Http\Controllers;

use App\Models\CloseFriend;
use App\Models\Follow;
use Illuminate\Http\Request;

class CloseFriendController extends Controller
{
    public function index()
    {
        $currentUserId = session('current_user_id');

        $closeFriends = CloseFriend::where('user_id', $currentUserId)
            ->with('closeFriend')
            ->get();

        return view('friends.close_friends', compact('closeFriends'));
    }

    public function store($id)
    {
        $currentUserId = session('current_user_id');

        if ($currentUserId == $id) {
            return redirect()->back()->with('error', 'You cannot add yourself as close friend.');
        }

        $isFollower = Follow::where('follower_id', $id)
            ->where('following_id', $currentUserId)
            ->exists();

        if (!$isFollower) {
            return redirect()->back()->with('error', 'Only followers can be added to close friends.');
        }

        CloseFriend::firstOrCreate([
            'user_id' => $currentUserId,
            'close_friend_id' => $id,
        ]);

        return redirect()->back()->with('success', 'User added to close friends.');
    }

    public function destroy($id)
    {
        $currentUserId = session('current_user_id');

        CloseFriend::where('user_id', $currentUserId)
            ->where('close_friend_id', $id)
            ->delete();

        return redirect()->back()->with('success', 'User removed from close friends.');
    }
}
