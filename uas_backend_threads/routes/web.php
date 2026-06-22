<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReplyEditController;
use App\Http\Controllers\ReplyLikeController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;



// Pengalihan Halaman Utama
Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('threads.index');
    }
    return redirect()->route('login');
});

// Rute Publik
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/{id}', [ThreadController::class, 'show'])->name('threads.show');

// Rute Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Rute Terproteksi Auth (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::get('/user-management', [AuthController::class, 'me'])->name('user-management');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Modul Threads
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');

    // Modul Hubungan Sosial
    Route::post('/follow/{id}', [RelationshipController::class, 'toggleFollow'])->name('follow.toggle');
    Route::get('/connections', [RelationshipController::class, 'index'])->name('connections');

    // Modul Bookmark
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');

    // Modul Like
    Route::post('/like/toggle', [LikeController::class, 'toggleLike'])->name('like.toggle');

    // Modul Replies
    Route::post('/reply', [ReplyController::class, 'store'])->name('reply.store');
    Route::get('/reply/edit/{id}', [ReplyEditController::class, 'edit'])->name('reply.edit');
    Route::put('/reply/update/{id}', [ReplyEditController::class, 'update'])->name('reply.update');
    Route::delete('/reply/delete/{id}', [ReplyController::class, 'destroy'])->name('reply.destroy');
    Route::post('/replies/{id}/like', [ReplyLikeController::class, 'toggleLike'])->name('replies.like');

    // Modul User & Profile
    Route::resource('updatethreads', UserController::class);
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});