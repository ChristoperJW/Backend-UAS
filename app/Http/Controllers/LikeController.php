<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    private function currentUserId()
    {
        return session('current_user_id');
    }

    public function store(Post $post)
    {
        if(!$this->currentUserId()) {
            return redirect('/login') -> with('Error', 'Tolong Login Terlebih Dahulu!');
        }

        Like::firstOrCreate([
            'user_id' => $this->currentUserId(),
            'post_id' => $post->id,
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Post Liked');
    }

    public function destroy(Post $post)
    {
        if(!$this->currentUserId()) {
            return redirect('/login') -> with('Error', 'Tolong Login Terlebih Dahulu!');
        }

        Like::where('user_id', $this->currentUserId())
        ->where('post_id', $post->id)
        ->delete();

        return redirect()->route('posts.show', $post)->with('success', 'Post Unliked');
    }
}
