<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;

Route::get('/', function () {
    return view('homepage');
});

Route::get('/switch-user/{id}',
    [FriendsController::class, 'switchUser']);

Route::get('/friends', [FriendsController::class, 'index'
]);

Route::get('/friends/followers', [FriendsController::class, 'followers']);

Route::get('/friends/following', [FriendsController::class, 'following']);

Route::post('/friends/{id}/follow', [FollowController::class, 'followWeb'])
    ->name('friends.follow');

Route::post('/friends/{id}/unfollow', [FollowController::class, 'unfollowWeb'])
    ->name('friends.unfollow');

Route::resource('posts', PostController::class);

Route::resource('comments', CommentController::class);
