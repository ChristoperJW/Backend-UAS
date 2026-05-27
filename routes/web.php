<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect('/comments');
});

Route::resource('comments', CommentController::class);
