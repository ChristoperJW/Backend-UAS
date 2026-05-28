<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $posts = Post::with(['user', 'likes']) 
            ->when($search, function ($query) use ($search) {
                return $query->where('caption', 'like', '%' . $search . '%');
            })
            ->latest()
            ->get();

        return view('posts.index', compact('posts', 'search'));
    }

    public function create()
    {
        return view ('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|string',
            'media' => 'nullable|string',
        ]);

        Post::create([
            'user_id' => 1,
            'caption' => $request->caption,
            'media' => $request->media,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post Created Successfully');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'likes']);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'caption' => 'required|string',
            'media' => 'nullable|string',
        ]);

        $post->update($request->only('caption', 'media'));

        return redirect()->route('posts.index')->with('success', 'Post Updated Successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', "Post Deleted Successfully");
    }
}
