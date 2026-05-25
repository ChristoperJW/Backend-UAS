<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'getConversations'])->name('messages.getConversations');
    Route::post('/messages/create', [MessageController::class, 'createConversation'])->name('messages.createConversation');
    Route::get('/messages/{userId}', [MessageController::class, 'getMessages'])->name('messages.getMessages');
    Route::post('/messages', [MessageController::class, 'sendMessage'])->name('messages.sendMessage');
    Route::delete('/messages/conversation/{userId}', [MessageController::class, 'removeFullConversation'])->name('messages.removeFullConversation');
    Route::delete('/messages/{messageId}', [MessageController::class, 'removeMessage'])->name('messages.removeMessage');
});