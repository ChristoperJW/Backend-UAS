<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Favorite;

class PostController extends Controller
{
    private function currentUserId()
    {
        return session('current_user_id');
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $tag = $request->tag;

        $tags = Tag::all();

        $posts = Post::with(['user', 'likes', 'comments', 'favorites', 'tags', 'taggedUsers'])
            ->when($search, function ($query) use ($search) {
                return $query->where('caption', 'like', '%' . $search . '%');
        })
            ->when($tag, function ($query) use ($tag) {
                return $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tags.id', $tag);
            });
        })
            ->latest()
            ->get();

        return view('posts.index', compact('posts', 'search', 'tag', 'tags'));
    }

    public function create()
    {
        if(!$this->currentUserId()) {
            return redirect('/login') -> with('error', 'Tolong Login Terlebih Dahulu!');
        }

        $tags = Tag::all();
        $users = User::where ('id', '!=', $this->currentUserId())->get();

        return view('posts.create', compact('tags', 'users')); 
    }

    public function store(Request $request)
    {
        if(!$this->currentUserId()) {
            return redirect('/login') -> with('error', 'Tolong Login Terlebih Dahulu!');
        }

        $request->validate([
            'caption' => 'required|string',
            'media' => 'nullable|string',
        ]);

        $post = Post::create([
            'user_id' => $this->currentUserId(),
            'caption' => $request->caption,
            'media' => $request->media,
        ]);

        $post->tags()->sync($request->tags ?? []); 
        $post->taggedUsers()->sync($request->tagged_users ?? []);

        foreach ($request->tagged_users ?? [] as $userId) {
            NotificationController::create(
                $userId,
                $this->currentUserId(),
                'tag_post',
                $post->id
            );
        }

        return redirect()->route('posts.index')->with('success', 'Post Created Successfully');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'likes', 'comments', 'favorites', 'tags', 'taggedUsers']);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if($post->user_id != $this->currentUserId()) {
            return redirect() -> route('posts.index') -> with ('error', 'Anda Tidak Punya Akses Untuk Mengedit Postingan Ini!');
        }

        $tags = Tag::all();
        $users = User::where ('id', '!=', $this->currentUserId())->get();
        
        return view('posts.edit', compact('post', 'tags', 'users'));
    }

    public function update(Request $request, Post $post)
    {
        if($post->user_id != $this->currentUserId()) {
            return redirect() -> route('posts.index') -> with ('error', 'Anda Tidak Punya Akses Untuk Mengupdate Postingan Ini!');
        }

        $request->validate([
            'caption' => 'required|string',
            'media' => 'nullable|string',
        ]);

        $post->update($request->only('caption', 'media'));

        $oldTaggedUserIds = $post->taggedUsers()->pluck('users.id')->toArray();
        $newTaggedUserIds = $request->tagged_users ?? [];

        $post->tags()->sync($request->tags ?? []);
        $post->taggedUsers()->sync($request->tagged_users ?? []);

        $addedTaggedUserIds = array_diff($newTaggedUserIds, $oldTaggedUserIds);

        foreach ($addedTaggedUserIds as $userId) {
            NotificationController::create(
                $userId,
                $this->currentUserId(),
                'tag_post',
                $post->id
            );
        }

        return redirect()->route('posts.index')->with('success', 'Post Updated Successfully');
    }

    public function destroy(Post $post)
    {
        if($post->user_id != $this->currentUserId()) {
            return redirect() -> route('posts.index') -> with ('error', 'Anda Tidak Punya Akses Untuk Menghapus Postingan Ini!');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', "Post Deleted Successfully");
    }

    public function myPosts()
    {
    if (!$this->currentUserId()) {
        return redirect('/login')->with('error', 'Tolong Login Terlebih Dahulu!');
    }

    $posts = Post::with(['user', 'likes', 'comments', 'favorites', 'tags', 'taggedUsers'])
        ->where('user_id', $this->currentUserId())
        ->latest()
        ->get();

    return view('posts.my-posts', compact('posts'));
    }
}
