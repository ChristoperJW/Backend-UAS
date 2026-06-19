<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getConversations()
    {
        $userId = session('current_user_id');
        
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $conversations = collect();
        foreach ($messages as $message) {
            if (is_null($message->group_id)) {
                $otherUserId = $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
                
                if (!$conversations->has($otherUserId) && !is_null($otherUserId)) {
                    $conversations->put($otherUserId, User::find($otherUserId));
                }
            }
        }
        
        $activeChats = $conversations->values();
        $allUsers = User::orderBy('name', 'asc')->get();

        $groups = Group::whereHas('members', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return view('messages.index', compact('activeChats', 'allUsers', 'groups'));
    }

    public function searchUsers(Request $request)
    {
        $search = $request->query('q');
        
        if (!$search) {
            return response()->json([]);
        }

        $users = User::where('name', 'like', '%' . $search . '%')
                    ->orderBy('name', 'asc')
                    ->limit(10)
                    ->get(['id', 'name']);

        return response()->json($users);
    }

    public function createConversation(Request $request)
    {
        $request->validate([
            'name' => 'required|exists:users,name'
        ]);

        $receiver = User::where('name', $request->name)->first();

        return redirect()->route('messages.getMessages', $receiver->id);
    }

    public function getMessages($userId)
    {
        $receiver = User::findOrFail($userId);
        $currentUserId = session('current_user_id');

        Message::where('sender_id', $userId)
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where(function($q) use ($userId, $currentUserId) {
            $q->where('sender_id', $currentUserId)
              ->where('receiver_id', $userId)
              ->where('deleted_by_sender', false);
        })->orWhere(function($q) use ($userId, $currentUserId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', $currentUserId)
              ->where('deleted_by_receiver', false);
        })->orderBy('created_at', 'asc')->paginate(50);

        return view('messages.show', compact('receiver', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
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

        Message::create([
            'sender_id' => session('current_user_id'),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content ?? '',
            'media_path' => $mediaPath,
            'media_type' => $mediaType
        ]);

        return back();
    }

    public function removeFullConversation($userId)
    {
        Message::where(function($q) use ($userId) {
            $q->where('sender_id', session('current_user_id'))->where('receiver_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)->where('receiver_id', session('current_user_id'));
        })->delete();

        return redirect()->route('messages.getConversations');
    }

    public function removeMessage(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);
        $currentUserId = session('current_user_id');

        if ($request->type === 'for_everyone') {
            if ($message->sender_id == $currentUserId) {
                $message->content = 'Pesan telah dihapus';
                $message->save();
            }
        } else {
            if ($message->sender_id == $currentUserId) {
                $message->deleted_by_sender = true;
            }
            
            if ($message->receiver_id == $currentUserId) {
                $message->deleted_by_receiver = true;
            }
            $message->save();
        }
        return back();
    }
}