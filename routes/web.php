<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\RegisterController;

Route::get('/register', [RegisterController::class, 'index']);

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', function () {
    if (!session()->has('current_user_id')) {
        return redirect('/login')->with('error', 'Please log in first!');
    }
    
    return view('homepage');
});

Route::get('/login', [LoginController::class, 'index']);

Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout']);

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
