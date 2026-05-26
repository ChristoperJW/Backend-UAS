<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        Like::firstOrCreate([
            'user_id' => 1,
            'post_id' => $post->id,
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Post Liked');
    }

    public function destroy(Post $post)
    {
        Like::where('user_id',1)
        ->where('post_id', $post->id)
        ->delete();

        return redirect()->route('posts.show', $post)->with('success', 'Post Unliked');
    }
}
