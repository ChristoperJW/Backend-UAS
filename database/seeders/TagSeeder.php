<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ['Study', 'Holiday', 'Weekend', 'Event', 'Food', 'Travel', 'Lifestyle', 'Health', 'Fitness', 'Technology', 'Education', 'Entertainment', 'Fashion', 'Business', 'Finance', 'Sports', 'Music', 'Art', 'Culture', 'Nature'];

        foreach ($tags as $tag) { 
            Tag::updateOrCreate(
                ['name' => $tag]
            );
        }
    }
}
