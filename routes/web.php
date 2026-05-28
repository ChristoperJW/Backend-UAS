<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/friends', function (){
    return view('friends.index');
});

Route::get('friends/followers', function(){
    return view('friends.followers');
});

Route::get('friends/following', function(){
    return view('friends.following');
});

Route::resource('comments', CommentController::class);
