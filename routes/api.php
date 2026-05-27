<?php

use App\Http\Controllers\FollowController;

Route::prefix('users')->group(function () {

    Route::post('{id}/follow', [FollowController::class, 'follow']);

    Route::post('{id}/unfollow', [FollowController::class, 'unfollow']);

    Route::get('{id}/followers', [FollowController::class, 'followers']);

    Route::get('{id}/following', [FollowController::class, 'following']);
});