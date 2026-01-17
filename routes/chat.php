<?php

use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\ChatMessageController;
use App\Http\Controllers\Seller\SellerFollowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Chat routes - IMPORTANT: Order matters!
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

    // More specific routes come before wildcard routes
    Route::get('/chat/seller/{seller}', [ChatController::class, 'startWithSeller'])->name('chat.seller');
    Route::get('/chat/start/{seller}', [ChatController::class, 'startWithSeller'])->name('chat.startWithSeller');

    // Wildcard route comes last (consider adding whereNumber or whereUuid if chat IDs are numeric/uuid)
    Route::get('/chat/{chat}', [ChatController::class, 'index'])->name('chat.conversation');

    // Chat message actions
    Route::post('/chat/{chat}/messages', [ChatMessageController::class, 'store'])->name('chat.messages.store');
    Route::post('/chat/{chat}/messages/image', [ChatMessageController::class, 'storeImage'])->name('chat.messages.image');
    Route::delete('/chat/messages/{message}', [ChatMessageController::class, 'destroy'])->name('chat.messages.destroy');

    // Mark-as-read
    Route::post('/chat/{chat}/mark-as-read', [ChatController::class, 'markAsRead'])->name('chat.mark-as-read');

    // Typing indicators (separate endpoints for start and stop)
    Route::post('/chat/{chat}/typing', [ChatController::class, 'updateTyping'])->name('chat.typing');
    Route::post('/chat/{chat}/stop-typing', [ChatController::class, 'stopTyping'])->name('chat.stop-typing');

    // Unread count (auth protected)
    Route::get('/chat/unread-count', [ChatController::class, 'unreadCount'])->name('chat.unread-count');

    // Store follow/unfollow routes (auth required)
    Route::post('/stores/{seller}/follow', [SellerFollowController::class, 'store'])->name('stores.follow');
    Route::delete('/stores/{seller}/follow', [SellerFollowController::class, 'destroy'])->name('stores.unfollow');
});