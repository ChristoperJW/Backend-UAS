<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=> 'Louise',
            'email'=> 'louise@example.com',
            'password'=> Hash::make('louise123')
        ]);

        User::create([
            'name'=> 'Christoper',
            'email'=> 'christoper@example.com',
            'password'=> Hash::make('christoper123')
        ]);
        
        User::create([
            'name'=> 'Michael',
            'email'=> 'michael@example.com',
            'password'=> Hash::make('michael123')
        ]);

        User::create([
            'name'=> 'Monica',
            'email'=> 'monica@example.com',
            'password'=> Hash::make('monica123')
        ]);

        User::create([
            'name'=> 'Angga',
            'email'=> 'angga@example.com',
            'password'=> Hash::make('angga123')
        ]);
    }
}
