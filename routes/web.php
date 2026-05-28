<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/friends', [FriendsController::class, 'index'
]);

Route::get('friends/followers', function(){
    return view('friends.followers');
});

Route::get('friends/following', function(){
    return view('friends.following');
});

Route::resource('comments', CommentController::class);
