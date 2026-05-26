<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;

Route::get('/', function () {
    return redirect('/feeds');
});

