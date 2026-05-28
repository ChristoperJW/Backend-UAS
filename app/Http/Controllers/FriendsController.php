<?php

namespace App\Http\Controllers;

use App\Models\User;

class FriendsController extends Controller
{
    public function index()
    {
        $currentId = 1;

        $suggestions = User::where('id', '!=', $currentId)
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('friends.index', compact('suggestions'));
    }
}
