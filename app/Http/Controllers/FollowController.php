<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow($id)
    {
        $currentUserId = 1; // Because the auth system hasn't done yet, assume the user who did it is id = 1

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
        $currentUserId = 1;

        $follow = Follow::where('follower_id', $currentUserId)
            ->where('following_id', $id)
            ->first();

        if(!follow){
            return response()->json([
                'message' => 'Follow relationship not found'
            ], 400);
        }

        $follow->delete();
        
        return response()-json([
            'message' => 'User unfollowed successfully'
        ]);
    }

    public function followers($id)
    {

    }
    
    public function following($id)
    {
        
    }
}
