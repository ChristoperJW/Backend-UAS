<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
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
            $otherUserId = $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
            if (!$conversations->has($otherUserId)) {
                $conversations->put($otherUserId, User::find($otherUserId));
            }
        }
        
        $activeChats = $conversations->values();
        $allUsers = User::where('id', '!=', $userId)->orderBy('name', 'asc')->get();

        return view('messages.index', compact('activeChats', 'allUsers'));
    }

    public function createConversation(Request $request)
    {
        $request->validate(['receiver_id' => 'required|exists:users,id']);
        return redirect()->route('messages.getMessages', $request->receiver_id);
    }

    public function getMessages($userId)
    {
        $receiver = User::findOrFail($userId);
        $messages = Message::where(function($q) use ($userId) {
            $q->where('sender_id', session('current_user_id'))->where('receiver_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)->where('receiver_id', session('current_user_id'));
        })->orderBy('created_at', 'asc')->paginate(50);

        return view('messages.show', compact('receiver', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string'
        ]);

        Message::create([
            'sender_id' => session('current_user_id'),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content
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

    public function removeMessage($messageId)
    {
        $message = Message::findOrFail($messageId);
        if ($message->sender_id === session('current_user_id')) {
            $message->delete();
        }
        return back();
    }
}