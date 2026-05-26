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
        $user = User::firstOrCreate([
            'name'     => 'monica',
            'email'    => 'monica@gmail.com',
            'password' => bcrypt('monica123'),
        ]);

        $post = Post::firstOrCreate([
            'caption' => 'image1',
            'user_id' => $user->id, 'media' => 'image1.jpg'
        ]);

        Comment::create([
            'content' => 'unggah',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}