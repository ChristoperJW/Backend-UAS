<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow($id)
    {
        $currentUserId = session('current_user_id', 1);

        if($currentUserId == $id) {
            return response()->json([
                'message' => 'You cannot follow yourself'
            ], 400);
        }

        $existingFollow = Follow::where('follower_id', $currentUserId)
            ->where('following_id', $id)
            ->first();

        if($existingFollow) {
            return response()->json([
                'message' => 'User already followed'
            ], 400);
        }

        Follow::create([
            'follower_id' => $currentUserId,
            'following_id' => $id
        ]);

        return response()->json([
            'message' => 'User followed successfully'
        ], 201);
    }

    public function unfollow($id)
    {
        $currentUserId = session('current_user_id', 1);

        $follow = Follow::where('follower_id', $currentUserId)
            ->where('following_id', $id)
            ->first();

        if(!$follow){
            return response()->json([
                'message' => 'Follow relationship not found'
            ], 400);
        }

        $follow->delete();
        
        return response()->json([
            'message' => 'User unfollowed successfully'
        ]);
    }

    public function followers($id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'message'=> 'User not found'
            ], 404);
        }

        return response()->json([
            'followers'=> $user->followers
        ]);
    }
    
    public function following($id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'message'=> 'User not found'
            ], 404);
        }

        return response()->json([
            'following' => $user->following
        ]);
    }

    public function followStats($id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'message'=> 'User not found'
            ], 404);
        }

        return response()->json([
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count()
        ]);
    }

    public function followWeb($id)
    {
        $currentUserId = session('current_user_id', 1);

        $alreadyFollowed = Follow::where('follower_id', $currentUserId)
            ->where('following_id', $id)
            ->exists();

        if (!$alreadyFollowed) {
            Follow::create([
                'follower_id' => $currentUserId,
                'following_id' => $id
            ]);
        }

        return back()
            ->with('success', 'User followed successfully');
    }

    public function unfollowWeb($id)
    {
        $currentUserId = session('current_user_id', 1);

        Follow::where('follower_id', $currentUserId)
            ->where('following_id', $id)
            ->delete();

        return back()
            ->with('success', 'User unfollowed successfully');
    }
}
