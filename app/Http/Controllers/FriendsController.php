<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;

class FriendsController extends Controller
{
    public function index(Request $request)
    {
        $currentUserId = session('current_user_id', 1);

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

    public function switchUser($id)
    {
        session(['current_user_id' => $id]);
        return redirect('/friends');
    }

    public function followers()
    {
        $currentUserId = session('current_user_id', 1);

        $followers = User::whereIn('id', function ($query) use ($currentUserId) {
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