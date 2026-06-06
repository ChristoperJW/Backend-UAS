<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'monica@example.com')->firstOrFail();

        $post = Post::firstOrCreate([
            'caption' => 'A cat!',
            'user_id' => $user->id,
            'media' => 'cat.jpeg'
        ]);

        Comment::create([
            'content' => 'Cute cat!',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}