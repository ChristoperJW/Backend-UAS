<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;
use App\Models\FollowRequest;
use App\Models\CloseFriend;

class FriendsController extends Controller
{
    public function index(Request $request)
    {
        $currentUserId = session('current_user_id');

        $currentUser = User::find($currentUserId);

        $followedUsers = Follow::where('follower_id', $currentUserId)
            ->pluck('following_id');

        $suggestions = User::where('id', '!=', $currentUserId)
            ->whereNotIn('id', $followedUsers)
            ->inRandomOrder()
            ->take(3)
            ->get();

        $searchResults = collect();

        if ($request->filled('search')) {
            $searchResults = User::where('id', '!=', $currentUserId)
                ->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                })
                ->get();
        }

        $followersCount = Follow::where('following_id', $currentUserId)->count();

        $followingCount = Follow::where('follower_id', $currentUserId)->count();

        return view('friends.index', compact(
            'suggestions',
            'searchResults',
            'followedUsers',
            'followersCount',
            'followingCount',
            'currentUser'
        ));
    }

    public function followers()
    {
    $currentUserId = session('current_user_id');

    $followers = User::whereIn('id', function ($query) use ($currentUserId) {
        $query->select('follower_id')
            ->from('follows')
            ->where('following_id', $currentUserId);
    })->get();

    $closeFriendIds = CloseFriend::where('user_id', $currentUserId)
        ->pluck('close_friend_id')
        ->toArray();

    return view('friends.followers', compact(
        'followers',
        'closeFriendIds'
    ));
    }

    public function following()
    {
        $currentUserId = session('current_user_id');

        $followingIds = Follow::where('follower_id', $currentUserId)
                ->pluck('following_id');

        $followingUsers = User::whereIn('id', $followingIds)->get();

        return view('friends.following', compact('followingUsers'));
    }

    public function discover() 
    {
        if (!session()->has('current_user_id')) {
            return redirect('/login')->with('error', 'Please log in first');
        }

        $currentUserId = session('current_user_id');

        $followingIds = Follow::where('follower_id', $currentUserId)
            ->pluck('following_id');

        $discoverUserIds = Follow::whereIn('follower_id', $followingIds)
            ->where('following_id', '!=', $currentUserId)
            ->whereNotIn('following_id', $followingIds)
            ->pluck('following_id')
            ->unique();

        $discoverUsers = User::whereIn('id', $discoverUserIds)->get();

        foreach ($discoverUsers as $user) {
            $user->mutual_count = Follow::whereIn('follower_id', $followingIds)
                ->where('following_id', $user->id)
                ->count();
        }

        return view('friends.discover', compact('discoverUsers'));
    }

    public function profile($id)
    {
        if (!session()->has('current_user_id')) {
            return redirect('/login')->with('error', 'Please log in first');
        }

        $currentUserId = session('current_user_id');

        $user = User::findOrFail($id);

        $followersCount = Follow::where('following_id', $id)->count();

        $followingCount = Follow::where('follower_id', $id)->count();

        $isFollowing = Follow::where('follower_id', $currentUserId)
            ->where('following_id', $id)
            ->exists();

        $isOwner = $currentUserId == $user->id;
        
        $isCloseFriend = CloseFriend::where('user_id', $user->id)
            ->where('close_friend_id', $currentUserId)
            ->exists();

        $canViewProfile = !$user->is_private || $isOwner || $isFollowing;

        return view('friends.profile', compact(
            'user',
            'followersCount',
            'followingCount',
            'isFollowing',
            'currentUserId',
            'canViewProfile',
            'isCloseFriend',
        ));
    }

    public function requests()
    {
        if (!session()->has('current_user_id')) {
            return redirect('/login')->with('error', 'Please log in first.');
        }

        $currentUserId = session('current_user_id');

        $followRequests = FollowRequest::with('sender')
            ->where('receiver_id', $currentUserId)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('friends.requests', compact('followRequests'));
    }
}