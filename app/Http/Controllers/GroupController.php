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
        ->orderBy('created_at', 'asc')
        ->get();

    return view('groups.show', compact('group', 'messages'));
}

public function sendMessage(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    $currentUserId = session('current_user_id');

    Message::create([
        'sender_id' => $currentUserId,
        'group_id' => $id,
        'content' => $request->content,
    ]);

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