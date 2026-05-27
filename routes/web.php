<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/friends', function (){
    return view('friends.index');
});

Route::resource('comments', CommentController::class);
