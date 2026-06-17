<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReplyEditController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\Reply;


Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) { // 👈 Menggunakan Facade Auth resmi
        return redirect()->route('threads.index');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
    Route::get('/threads/{id}', [ThreadController::class, 'show'])->name('threads.show');

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');

    Route::post('/reply', [ReplyController::class, 'store'])->name('reply.store');
    Route::get('/reply/edit/{id}', [ReplyEditController::class, 'edit'])->name('reply.edit');
    Route::put('/reply/update/{id}', [ReplyEditController::class, 'update']);

    Route::post('/follow/{id}', [RelationshipController::class, 'toggleFollow'])->name('follow.toggle');
    Route::get('/connections', [RelationshipController::class, 'index'])->name('connections');

    Route::get('/search', [SearchController::class, 'index'])->name('search');

    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::get('/thread/demo', function () {
        $replies = Reply::where('thread_id', 1)
            ->whereNull('parent_reply_id')
            ->with('childReplies')
            ->get();
        return view('replies.thread-detail', compact('replies'));
    });
});
