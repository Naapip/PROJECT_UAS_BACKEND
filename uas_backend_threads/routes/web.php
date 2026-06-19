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

// Halaman Utama (Bisa diakses siapa saja)
Route::get('/', function () {
    return view('welcome');
});

// =========================================================================
// 1. GUEST ROUTES (Hanya bisa diakses jika BELUM login)
// =========================================================================
Route::middleware('guest')->group(function () {
    // Fitur Registrasi
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Fitur Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// =========================================================================
// 2. AUTH ROUTES (Hanya bisa diakses jika SUDAH login)
// =========================================================================
Route::middleware('auth')->group(function () {
    
    // Halaman User Management / Dashboard bawaan AuthController
    Route::get('/user-management', [AuthController::class, 'me'])->name('user-management');
    
    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur Threads (Membuat & Menyimpan Thread)
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');

    // Fitur Reply (Membuat, Edit, Update Balasan)
    Route::post('/reply', [ReplyController::class, 'store'])->name('reply.store');
    Route::get('/reply/edit/{id}', [ReplyEditController::class, 'edit'])->name('reply.edit');
    Route::put('/reply/update/{id}', [ReplyEditController::class, 'update']);

    // Fitur Follow / Hubungan Sosial
    Route::post('/follow/{id}', [RelationshipController::class, 'toggleFollow'])->name('follow.toggle');
    Route::get('/connections', [RelationshipController::class, 'index'])->name('connections');

    // Fitur Bookmark (Menyimpan & Melihat Bookmark)
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');

    // Resource Route untuk User / Update Threads
    Route::resource('updatethreads', UserController::class);
});

// =========================================================================
// 3. PUBLIC / SHARED ROUTES (Bisa diakses Publik, atau sesuaikan kebutuhan)
// =========================================================================
// Pencarian
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Melihat Daftar Kumpulan Thread
Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');

// Demo Halaman Detail Thread & Balasan Berisi Relasi Parent-Child
Route::get('/thread/demo', function () {
    $replies = Reply::where('thread_id', 1)
        ->whereNull('parent_reply_id')
        ->with('childReplies')
        ->get();
    return view('replies.thread-detail', compact('replies'));
});