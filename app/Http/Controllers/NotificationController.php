<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private function currentUserId()
    {
        return session('current_user_id');
    }

    public function index()
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }
 
        $notifications = Notification::with(['sender', 'post'])
            ->where('user_id', $this->currentUserId())
            ->latest()
            ->get();
 
        // Tandai semua sebagai sudah dibaca
        Notification::where('user_id', $this->currentUserId())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
 
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', $this->currentUserId())
            ->firstOrFail();
 
        $notification->update(['read_at' => now()]);
 
        return back();
    }

    public static function create($userId, $senderId, $type, $postId = null)
    {
        if ($userId == $senderId) return;
 
        Notification::create([
            'user_id'  => $userId,
            'sender_id' => $senderId,
            'type'     => $type,
            'post_id'  => $postId,
        ]);
    }
}
