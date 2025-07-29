<?php

// file: routes/web.php
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;


Route::get('/', function () {
    $posts = Post::with('user')->where('status', 'public')->latest()->get();
    return view('welcome', ['posts' => $posts]);
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- БЛОК МАРШРУТОВ ДЛЯ ПОСТОВ ---

Route::get('/tags/{tag:name}', [TagController::class, 'show'])->name('tags.show');

// Маршрут для создания поста (конкретный) - должен идти раньше
// Он должен быть внутри группы 'auth', т.к. создавать посты могут только авторизованные
Route::get('/posts/create', [PostController::class, 'create'])
    ->middleware('auth')->name('posts.create');

// Маршрут для сохранения нового поста
Route::post('/posts', [PostController::class, 'store'])
    ->middleware('auth')->name('posts.store');

// Маршрут для показа одного поста (общий с параметром) - идет позже
// Он публичный, middleware('auth') ему не нужен
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Маршрут для страницы редактирования поста
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
    ->middleware('auth')->name('posts.edit');

// Маршрут для обновления поста (используем метод PUT/PATCH)
Route::patch('/posts/{post}', [PostController::class, 'update'])
    ->middleware('auth')->name('posts.update');

// Маршрут для удаления поста (используем метод DELETE)
Route::delete('/posts/{post}', [PostController::class, 'destroy'])
    ->middleware('auth')->name('posts.destroy');

// Маршрут для сохранения комментария
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')->name('comments.store');
    
// --- ОСТАЛЬНЫЕ МАРШРУТЫ ---

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/feed', [PostController::class, 'feed'])->name('posts.feed');

    Route::post('/users/{user}/follow', [SubscriptionController::class, 'store'])->name('users.follow');
    Route::delete('/users/{user}/unfollow', [SubscriptionController::class, 'destroy'])->name('users.unfollow');
});

Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

require __DIR__.'/auth.php';