<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Post;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    private function currentUserId()
    {
        return session('current_user_id');
    }

    public function create()
    {
         if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        return view('stories.create');
    }

    public function store(Request $request)
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        $request->validate([
            'caption' => 'nullable|string|max:255',
            'media' => 'required|file|mimes:jpg,jpeg,png,mp4|max:20480',
        ]);

        $mediaName = time() . '_' . $request->file('media')->getClientOriginalName();
        $request->file('media')->move(public_path('uploads/stories'), $mediaName);

        Story::create([
            'user_id' => $this->currentUserId(),
            'caption' => $request->caption,
            'media' => $mediaName,
        ]);

        return redirect()->route('posts.index')->with('success', 'Story berhasil dibuat.');
    }

    public function destroy(Story $story)
    {
        if (!$this->currentUserId()) {
            return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
        }

        if ($story->user_id != $this->currentUserId()) {
            return redirect()->route('posts.index')->with('error', 'Anda tidak punya akses untuk menghapus story ini.');
        }

        if ($story->media && file_exists(public_path('uploads/stories/' . $story->media))) {
            unlink(public_path('uploads/stories/' . $story->media));
        }

        $story->delete();

        return redirect()->route('posts.index')->with('success', 'Story berhasil dihapus.');
    }
}

