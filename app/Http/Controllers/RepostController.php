<?php

namespace App\Http\Controllers;

use App\Models\Repost;
use App\Models\Post;
use Illuminate\Http\Request;

class RepostController extends Controller
{
    private function currentUserId()
    {
        return session('current_user_id');
    }

    public function index()
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        $reposts = Repost::with([
                'user',
                'post.user',
                'post.likes',
                'post.comments',
                'post.favorites',
                'post.reposts',
                'post.tags',
                'post.taggedUsers'
            ])
            ->where('user_id', $this->currentUserId())
            ->latest()
            ->get();

        return view('reposts.index', compact('reposts'));
    }

    public function create(Post $post)
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        if ($post->user_id == $this->currentUserId()) {
            return redirect()->route('posts.show', $post)
                ->with('error', 'Anda tidak bisa repost postingan sendiri.');
        }

        $post->load(['user', 'likes', 'comments', 'favorites', 'reposts', 'tags', 'taggedUsers']);

        return view('reposts.create', compact('post'));
    }

    public function store(Request $request, Post $post)
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        if ($post->user_id == $this->currentUserId()) {
        return redirect()->route('posts.show', $post)
            ->with('error', 'Anda tidak bisa repost postingan sendiri.');
        }

        $request->validate([
            'caption' => 'nullable|string|max:300',
        ]);

        $existingRepost = Repost::where('user_id', $this->currentUserId())
            ->where('post_id', $post->id)
            ->first();

        if ($existingRepost) {
            return redirect()->route('posts.show', $post)
                ->with('error', 'Post ini sudah pernah kamu repost.');
        }

        Repost::create([
            'user_id' => $this->currentUserId(),
            'post_id' => $post->id,
            'caption' => $request->caption,
        ]);

        NotificationController::create(
            $post->user_id,
            $this->currentUserId(),
            'repost',
            $post->id
        );

        return redirect()->route('reposts.index')->with('success', 'Post berhasil direpost.');
    }

    public function destroy(Repost $repost)
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        if ($repost->user_id != $this->currentUserId()) {
            return redirect()->route('reposts.index')
                ->with('error', 'Anda tidak punya akses untuk menghapus repost ini.');
        }

        $repost->delete();

        return redirect()->route('reposts.index')->with('success', 'Repost berhasil dihapus.');
    }
}

