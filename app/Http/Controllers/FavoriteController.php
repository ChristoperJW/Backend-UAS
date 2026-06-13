<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Post;
use Illuminate\Http\Request;

class FavoriteController extends Controller
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

        $favorites = Favorite::with([ 
                'post.user',
                'post.likes',
                'post.comments',
                'post.tags',
                'post.taggedUsers' 
            ])
            ->where('user_id', $this->currentUserId())
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        Favorite::firstOrCreate([
            'user_id' => $this->currentUserId(),
            'post_id' => $post->id,
        ]);

        return back()->with('success', 'Post berhasil disimpan ke favorit.');
    }

    public function destroy(Favorite $favorite)
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        Favorite::where('user_id', $this->currentUserId())
            ->where('post_id', $post->id)
            ->delete();

        return back()->with('success', 'Post dihapus dari favorit.');
    }
}
