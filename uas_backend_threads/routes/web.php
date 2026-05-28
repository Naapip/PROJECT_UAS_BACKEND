<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/search', [SearchController::class, 'index'])->name('search');


Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
