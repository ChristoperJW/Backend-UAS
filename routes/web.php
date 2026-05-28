<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/switch-user/{id}',
    [FriendsController::class, 'switchUser']);

Route::get('/friends', [FriendsController::class, 'index'
]);

Route::get('/friends/followers', [FriendsController::class, 'followers']);

Route::get('/friends/following', function(){
    return view('friends.following');
});

Route::post('/friends/{id}/follow', [FollowController::class, 'followWeb'])
    ->name('friends.follow');

Route::resource('posts', PostController::class);

Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');

Route::resource('comments', CommentController::class);
