<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;

class LikeController extends Controller
{
    private function currentUserId()
    {
        return session('current_user_id');
    }

    public function store(Post $post)
    {
        if(!$this->currentUserId()) {
            return redirect('/login') -> with('error', 'Tolong Login Terlebih Dahulu!');
        }

        Like::firstOrCreate([
            'user_id' => $this->currentUserId(),
            'post_id' => $post->id,
        ]);

        NotificationController::create(
        $post->user_id, $this->currentUserId(), 'like', $post->id);

        if (str_contains(url()->previous(), 'feeds')) {
            return redirect()->route('feeds.index');
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post Liked');
    }

    public function destroy(Post $post)
    {
        if(!$this->currentUserId()) {
            return redirect('/login') -> with('error', 'Tolong Login Terlebih Dahulu!');
        }

        Like::where('user_id', $this->currentUserId())
        ->where('post_id', $post->id)
        ->delete();

        if (str_contains(url()->previous(), 'feeds')) {
            return redirect()->route('feeds.index');
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post Unliked');
    }
}
