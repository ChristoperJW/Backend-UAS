<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Message;

class GroupController extends Controller
{
    public function create()
    {
        $currentUserId = session('current_user_id');
        $users = User::where('id', '!=', $currentUserId)->get();
        
        return view('groups.create', compact('users'));
    }

    public function show($id)
    {
        $currentUserId = session('current_user_id');
        
        $group = Group::whereHas('members', function($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        })->with('members.user')->findOrFail($id);

        $messages = Message::where('group_id', $id)
            ->with('sender')
            ->where(function($q) use ($currentUserId) {
                $q->where('sender_id', '!=', $currentUserId)
                  ->orWhere(function($query) use ($currentUserId) {
                      $query->where('sender_id', $currentUserId)
                            ->where('deleted_by_sender', false);
                  });
            })
            ->orderBy('created_at', 'asc')
            ->paginate(50);

        return view('groups.show', compact('group', 'messages'));
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'content' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480'
        ]);

        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('messages_media', 'public');
            $mime = $file->getMimeType();
            $mediaType = str_starts_with($mime, 'video/') ? 'video' : 'image';
        }

        $currentUserId = session('current_user_id');

        Message::create([
            'sender_id' => $currentUserId,
            'group_id' => $id,
            'content' => $request->content ?? '',
            'media_path' => $mediaPath,
            'media_type' => $mediaType
        ]);

        return back();
    }

    public function removeMember($groupId, $userId)
    {
        $currentUserId = session('current_user_id');

        $isAdmin = GroupMember::where('group_id', $groupId)
            ->where('user_id', $currentUserId)
            ->where('role', 'admin')
            ->exists();

        if (!$isAdmin && $currentUserId != $userId) {
            return back();
        }

        GroupMember::where('group_id', $groupId)
            ->where('user_id', $userId)
            ->delete();

        if ($currentUserId == $userId) {
            return redirect()->route('messages.getConversations');
        }

        return back();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'members' => 'required|array|min:1',
        ]);

        $currentUserId = session('current_user_id');

        DB::beginTransaction();
        
        try {
            $group = Group::create([
                'name' => $request->name,
                'created_by' => $currentUserId,
            ]);

            GroupMember::create([
                'group_id' => $group->id,
                'user_id' => $currentUserId,
                'role' => 'admin',
            ]);

            foreach ($request->members as $memberId) {
                GroupMember::create([
                    'group_id' => $group->id,
                    'user_id' => $memberId,
                ]);
            }

            DB::commit();
            return redirect()->route('messages.getConversations');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back();
        }
    }
}