<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments'])->get();
        return view('comments.index', compact('posts'));
    }

    public function create(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        return view('comments.create', compact('post'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'komentar' => 'required|string|max:300',
            'post_id'  => 'required|exists:posts,id',
        ]);

        Comment::create([
            'content' => $request->input('komentar'),
            'post_id' => $request->input('post_id'),
            'user_id' => 1,
        ]);
        return redirect()->route('comments.index')->with('success', 'Comment created successfully.');
    }

    public function show(Comment $comment)
    {
        return view('comments.show', compact('comment'));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully.');
    }
}
