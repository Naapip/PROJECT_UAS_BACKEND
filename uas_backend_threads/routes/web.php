<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\UserController;
use App\Models\Reply;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');

Route::get('/thread/demo', function () {
    $replies = Reply::where('thread_id', 1)
        ->whereNull('parent_reply_id')
        ->with('childReplies')
        ->get();

    return view('replies.thread-detail', compact('replies'));
});

Route::post('/reply', [ReplyController::class, 'store'])->name('reply.store');


Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);