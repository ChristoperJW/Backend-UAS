<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
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

Route::get('/friends/following', [FriendsController::class, 'following']);

Route::post('/friends/{id}/follow', [FollowController::class, 'followWeb'])
    ->name('friends.follow');

Route::post('/friends/{id}/unfollow', [FollowController::class, 'unfollowWeb'])
    ->name('friends.unfollow');

Route::resource('posts', PostController::class);

Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');

Route::resource('comments', CommentController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'getConversations'])->name('messages.getConversations');
    Route::post('/messages/create', [MessageController::class, 'createConversation'])->name('messages.createConversation');
    Route::get('/messages/{userId}', [MessageController::class, 'getMessages'])->name('messages.getMessages');
    Route::post('/messages', [MessageController::class, 'sendMessage'])->name('messages.sendMessage');
    Route::delete('/messages/conversation/{userId}', [MessageController::class, 'removeFullConversation'])->name('messages.removeFullConversation');
    Route::delete('/messages/{messageId}', [MessageController::class, 'removeMessage'])->name('messages.removeMessage');
});