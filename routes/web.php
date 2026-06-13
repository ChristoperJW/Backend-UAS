<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    if (!session()->has('current_user_id')) {
        return redirect('/login')->with('error', 'Please log in first!');
    }
    
    return view('homepage');
});


Route::get('/register', [AuthController::class, 'indexSignup']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'indexLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);


Route::get('/account',function(){
    if (!session()->has('current_user_id')) {
        return redirect('/login')->with('error', 'Please log in first!');
    }
    return view('account');
});
Route::post('/account/delete', [AccountController::class, 'deleteAccount']);
Route::get('/account/update', [AccountController::class, 'indexUpdate']);
Route::post('/account/update', [AccountController::class, 'updateAccount']);


Route::get('/switch-user/{id}', [FriendsController::class, 'switchUser']);
Route::get('/friends', [FriendsController::class, 'index']);
Route::get('/friends/followers', [FriendsController::class, 'followers']);
Route::get('/friends/following', [FriendsController::class, 'following']);
Route::post('/friends/{id}/follow', [FollowController::class, 'followWeb'])->name('friends.follow');
Route::post('/friends/{id}/unfollow', [FollowController::class, 'unfollowWeb'])->name('friends.unfollow');
Route::get('/friends/discover', [FriendsController::class, 'discover']);
Route::post('/account/privacy', [AccountController::class, 'updatePrivacy']);
Route::get('/friends/requests', [FriendsController::class, 'requests'])->name('friends.request');
Route::post('/friends/requests/{id}/accept', [FollowController::class, 'acceptRequest'])->name('friends.requests.accept');
Route::post('/friends/requests/{id}/reject', [FollowController::class, 'rejectRequest'])->name('friends.requests.reject');
Route::get('/users/{id}/profile', [FriendsController::class, 'profile'])->name('users.profile');

Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my');
Route::resource('posts', PostController::class);
Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/posts/{post}/favorite', [FavoriteController::class, 'store'])->name('posts.favorite');
Route::delete('/posts/{post}/favorite', [FavoriteController::class, 'destroy'])->name('posts.unfavorite');
Route::get('/reposts', [RepostController::class, 'index'])->name('reposts.index');
Route::get('/posts/{post}/repost', [RepostController::class, 'create'])->name('posts.repost.create');
Route::post('/posts/{post}/repost', [RepostController::class, 'store'])->name('posts.repost');
Route::delete('/reposts/{repost}', [RepostController::class, 'destroy'])->name('reposts.destroy');
Route::resource('comments', CommentController::class);


Route::get('/feeds', [FeedController::class, 'index'])->name('feeds.index');
Route::post('/feeds/{post}/comment', [FeedController::class, 'comment'])->name('feeds.comment');


Route::group(['middleware' => function ($request, $next) {
    if (!session()->has('current_user_id')) {
        return redirect('/login')->with('error', 'Please log in first!');
    }
    return $next($request);
}], function () {
    Route::get('/messages', [MessageController::class, 'getConversations'])->name('messages.getConversations');
    Route::get('/messages/search', [MessageController::class, 'searchUsers'])->name('messages.searchUsers');
    Route::post('/messages/create', [MessageController::class, 'createConversation'])->name('messages.createConversation');
    Route::get('/messages/{userId}', [MessageController::class, 'getMessages'])->name('messages.getMessages');
    Route::post('/messages', [MessageController::class, 'sendMessage'])->name('messages.sendMessage');
    Route::delete('/messages/conversation/{userId}', [MessageController::class, 'removeFullConversation'])->name('messages.removeFullConversation');
    Route::delete('/messages/{messageId}', [MessageController::class, 'removeMessage'])->name('messages.removeMessage');
    Route::get('/switch-user/{id}', [FriendsController::class, 'switchUser']);
    Route::get('/friends', [FriendsController::class, 'index']);
    Route::get('/friends/followers', [FriendsController::class, 'followers']);
    Route::get('/friends/following', [FriendsController::class, 'following']);
    Route::post('/friends/{id}/follow', [FollowController::class, 'followWeb'])->name('friends.follow');
    Route::post('/friends/{id}/unfollow', [FollowController::class, 'unfollowWeb'])->name('friends.unfollow');
    Route::get('/friends/discover', [FriendsController::class, 'discover']);
    Route::post('/account/privacy', [AccountController::class, 'updatePrivacy']);
    Route::get('/friends/requests', [FriendsController::class, 'requests'])->name('friends.request');
    Route::post('/friends/requests/{id}/accept', [FollowController::class, 'acceptRequest'])->name('friends.requests.accept');
    Route::post('/friends/requests/{id}/reject', [FollowController::class, 'rejectRequest'])->name('friends.requests.reject');
    Route::get('/users/{id}/profile', [FriendsController::class, 'profile'])->name('users.profile');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups/store', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{id}/send', [GroupController::class, 'sendMessage'])->name('groups.sendMessage');
});

Route::get('/feeds', [FeedController::class, 'index'])->name('feeds.index');
Route::post('/feeds/{post}/comment', [FeedController::class, 'comment'])->name('feeds.comment');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
