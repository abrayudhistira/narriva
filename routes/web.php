<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth'])->name('dashboard');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::post('/posts/reply', [PostController::class, 'reply'])->name('posts.reply');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/comment/post', [PostController::class, 'comment'])->name('comment.post');
    Route::post('/reply/comment', [PostController::class, 'reply'])->name('reply.comment');


    Route::resource('posts', PostController::class);
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::post('/add-comment', [CommentController::class, 'addComment'])->name('addComment');
    Route::post('/add-reply', [CommentController::class, 'addReply'])->name('addReply');
    Route::post('/delete-comment', [CommentController::class, 'deleteComment'])->name('deleteComment');
    Route::post('/reply/comment', [PostController::class, 'reply'])->name('reply.comment');

    Route::post('/user/{user}/follow', [UserController::class, 'follow'])->name('follow');
    Route::delete('/user/{user}/unfollow', [UserController::class, 'unfollow'])->name('unfollow');
});

require __DIR__.'/auth.php';
