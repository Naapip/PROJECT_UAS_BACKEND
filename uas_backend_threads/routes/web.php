<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReplyEditController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ActivityController;
use App\Models\Reply;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// =========================================================================
// 1. GUEST ROUTES (Hanya bisa diakses jika BELUM login)
// =========================================================================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// =========================================================================
// 2. AUTH ROUTES (Hanya bisa diakses jika SUDAH login)
// =========================================================================
Route::middleware('auth')->group(function () {
    
    Route::get('/user-management', [AuthController::class, 'me'])->name('user-management');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur Threads
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');

    // Fitur Reply
    Route::post('/reply', [ReplyController::class, 'store'])->name('reply.store');
    Route::get('/reply/edit/{id}', [ReplyEditController::class, 'edit'])->name('reply.edit');
    Route::put('/reply/update/{id}', [ReplyEditController::class, 'update']);

    // Fitur Follow
    Route::post('/follow/{id}', [RelationshipController::class, 'toggleFollow'])->name('follow.toggle');
    Route::get('/connections', [RelationshipController::class, 'index'])->name('connections');

    // Fitur Bookmark
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');

    // API-style / CRUD User
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

// =========================================================================
// 3. PUBLIC ROUTES (Bisa diakses tanpa login)
// =========================================================================
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');

Route::get('/thread/demo', function () {
    $replies = Reply::where('thread_id', 1)
        ->whereNull('parent_reply_id')
        ->with('childReplies')
        ->get();

    return view('replies.thread-detail', compact('replies'));
});