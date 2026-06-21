<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;
use App\Models\FollowRequest;
use App\Models\CloseFriend;

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
        $currentUserId = session('current_user_id');

        $follow = Follow::where('follower_id', $currentUserId)
            ->where('following_id', $id)
            ->first();

        if (!$follow) {
            return response()->json([
                'message' => 'Follow relationship not found'
            ], 400);
        }

        $follow->delete();

        FollowRequest::where('sender_id', $currentUserId)
            ->where('receiver_id', $id)
            ->delete();

        CloseFriend::where('user_id', $id)
            ->where('close_friend_id', $currentUserId)
            ->delete();

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

        if ($currentUserId == $id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        $alreadyFollowed = Follow::where('follower_id', $currentUserId)
            ->where('following_id', $id)
            ->exists();

        if ($alreadyFollowed) {
            return back()->with('success', 'You already followed this user.');
        }

        $targetUser = User::find($id);

        if (!$targetUser) {
            return back()->with('error', 'User not found.');
        }

        if ($targetUser->require_follow_approval) {
            FollowRequest::firstOrCreate(
                [
                    'sender_id' => $currentUserId,
                    'receiver_id' => $id,
                ],
                [
                    'status' => 'pending',
                ]
            );

            return back()->with('success', 'Follow request sent.');
        }

        Follow::create([
            'follower_id' => $currentUserId,
            'following_id' => $id
        ]);

        NotificationController::create($id, $currentUserId, 'follow');

        return back()->with('success', 'User followed successfully');
    }

    public function unfollowWeb($id)
    {
        $currentUserId = session('current_user_id');

        Follow::where('follower_id', $currentUserId)
            ->where('following_id', $id)
            ->delete();

        FollowRequest::where('sender_id', $currentUserId)
            ->where('receiver_id', $id)
            ->delete();

        CloseFriend::where('user_id', $id)
            ->where('close_friend_id', $currentUserId)
            ->delete();

        return back()
            ->with('success', 'User unfollowed successfully');
    }

    public function acceptRequest($id)
    {
        $currentUserId = session('current_user_id');

        $request = FollowRequest::where('id', $id)
            ->where('receiver_id', $currentUserId)
            ->where('status', 'pending')
            ->firstOrFail();

        Follow::firstOrCreate([
            'follower_id' => $request->sender_id,
            'following_id' => $request->receiver_id,
        ]);

        $request->status = 'accepted';
        $request->save();

        return back()->with('success', 'Follow request accepted.');
    }

    public function rejectRequest($id)
    {
        $currentUserId = session('current_user_id');

        $request = FollowRequest::where('id', $id)
            ->where('receiver_id', $currentUserId)
            ->where('status', 'pending')
            ->firstOrFail();

        $request->status = 'rejected';
        $request->save();

        return back()->with('success', 'Follow request rejected.');
    }
}
