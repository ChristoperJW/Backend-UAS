<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private function currentUserId()
    {
        return session('current_user_id');
    }

    public function index()
    {
        if(!$this->currentUserId()) {
            return redirect('/login')->with('Error', 'Tolong Login Terlebih Dahulu!');
        }
        $posts = Post::with(['user', 'comments.user'])->get();
        return view('comments.index', compact('posts'));
    }

    public function create(Request $request)
    {
        if(!$this->currentUserId()) {
            return redirect('/login')->with('Error', 'Tolong Login Terlebih Dahulu!');
        }

        $post = Post::findOrFail($request->post_id);
        return view('comments.create', compact('post'));
    }

    public function store(Request $request)
    {
        if(!$this->currentUserId()) {
            return redirect('/login')->with('Error', 'Tolong Login Terlebih Dahulu!');
        }

        $request->validate([
            'komentar' => 'required|string|max:300',
            'post_id'  => 'required|exists:posts,id',
        ]);

        Comment::create([
            'content' => $request->input('komentar'),
            'post_id' => $request->input('post_id'),
            'user_id' => $this->currentUserId(),
        ]);

        return redirect()->route('comments.index')->with('success', 'Comment created successfully.');
    }

    public function show(Comment $comment)
    {
        if(!$this->currentUserId()) {
            return redirect('/login')->with('Error', 'Tolong Login Terlebih Dahulu!');
        }
        return view('comments.show', compact('comment'));
    }

    public function destroy(Comment $comment)
    {
        if(!$this->currentUserId()) {
            return redirect('/login')->with('Error', 'Tolong Login Terlebih Dahulu!');
        }

        if($comment->user_id !== $this->currentUserId()) {
            return redirect()->route('comments.index')->with('Error', 'Anda Tidak Punya Akses Untuk Menghapus Komentar Ini!');
        }

        $comment->delete();
        
        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully.');
    }
}