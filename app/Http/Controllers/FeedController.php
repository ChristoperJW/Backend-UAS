<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments'])->inRandomOrder()->take(3)->get();

    foreach ($posts as $post) {
        Feed::firstOrCreate(['post_id' => $post->id]);
    }

    return view('feeds.index', compact('posts'));
    }

    public function comment(Request $request, Post $post)
    {
    $request->validate(['content' => 'required|string']);

    Comment::create([
        'content' => $request->content,
        'user_id' => auth()->id(),
        'post_id' => $post->id,
    ]);
    }

}
