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

        $user2 = User::where('email', 'michael@example.com')->firstOrFail();

        $post2 = Post::firstOrCreate([
            'caption' => 'Liburan',
            'user_id' => $user2->id,
            'media' => '1781868609_Memancing.jpg'
        ]);

        Comment::create([
            'content' => 'Asik Liburan',
            'user_id' => $user2->id,
            'post_id' => $post2->id,
        ]);

        $post3 = Post::firstOrCreate([
            'caption' => 'Nonton',
            'user_id' => $user2->id,
            'media' => '1781512035_Opening_Demon_Slayer.mp4'
        ]);

        Comment::create([
            'content' => 'Film apa itu!',
            'user_id' => $user2->id,
            'post_id' => $post3->id,
        ]);
    }
}