<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReplyEditController;
use App\Http\Controllers\RelationshipController;
use App\Http\Controllers\BookmarkController;
use App\Models\Reply;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/search', [SearchController::class, 'index'])->name('search');


Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
Route::get('/threads/{id}', [ThreadController::class, 'show'])->name('threads.show');
// Route simulasi halaman detail thread untuk demo progres Naufal
Route::get('/thread/demo', function () {
    $replies = Reply::where('thread_id', 1)->whereNull('parent_reply_id')->with('childReplies')->get();
    return view('replies.thread-detail', compact('replies'));
});
Route::post('/reply', [ReplyController::class, 'store'])->name('reply.store');
// Rute untuk menampilkan halaman edit (GET)
Route::get('/reply/edit/{id}', [ReplyEditController::class, 'edit'])->name('reply.edit');
// Rute untuk memproses eksekusi update data ke database (PUT)
Route::put('/reply/update/{id}', [ReplyEditController::class, 'update']);

Route::post('/follow/{id}', [RelationshipController::class, 'toggleFollow'])->name('follow.toggle');

Route::get('/connections', [RelationshipController::class, 'index'])->name('connections');


Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
