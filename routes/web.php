<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\PasswordResetLinkController;
use App\Http\Controllers\NewPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Edit Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/{username}', [PublicProfileController::class, 'show'])->name('profile.public');
    //Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    //Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth',])->name('dashboard');
    Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/comment', [PostController::class, 'comment'])->name('posts.comment');
    //Route::post('/posts/reply', [PostController::class, 'reply'])->name('posts.reply');
    //Route::post('/comment/post', [PostController::class, 'comment'])->name('comment.post');
    Route::post('/reply/comment', [PostController::class, 'reply'])->name('reply.comment');


    Route::resource('posts', PostController::class);
    //Route::get('/', [PostController::class, 'index'])->name('posts.index');

    Route::post('/add-comment', [CommentController::class, 'addComment'])->name('addComment');
    Route::post('/reply-comment', [CommentController::class, 'addReply'])->name('reply.comment');
    Route::post('/delete-comment', [CommentController::class, 'deleteComment'])->name('deleteComment');
    //Route::post('/reply/comment', [PostController::class, 'reply'])->name('reply.comment');

    Route::post('/user/{user}/follow', [UserController::class, 'follow'])->name('follow');
    Route::delete('/user/{user}/unfollow', [UserController::class, 'unfollow'])->name('unfollow');
});

require __DIR__.'/auth.php';
