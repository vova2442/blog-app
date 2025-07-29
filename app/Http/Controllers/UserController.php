<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Показать профиль пользователя и его посты.
     */
// file: app/Http/Controllers/UserController.php
    public function show(User $user)
    {
        $postsQuery = $user->posts()->where('status', 'public')->latest();

        // Если мы смотрим свой собственный профиль, то показываем все свои посты
        if (Auth::check() && Auth::id() === $user->id) {
            $postsQuery = $user->posts()->latest();
        }

        $posts = $postsQuery->get();

        $isFollowing = Auth::check() ? Auth::user()->following->contains($user->id) : false;

        return view('users.show', [
            'user' => $user,
            'posts' => $posts,
            'isFollowing' => $isFollowing
        ]);
    }
}