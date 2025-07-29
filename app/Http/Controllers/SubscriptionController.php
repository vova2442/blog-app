<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Подписаться на пользователя.
     */
    public function store(User $user)
    {
        // Нельзя подписаться на самого себя
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Вы не можете подписаться на самого себя.');
        }

        Auth::user()->following()->attach($user->id);

        return back()->with('success', 'Вы успешно подписались на ' . $user->name);
    }

    /**
     * Отписаться от пользователя.
     */
    public function destroy(User $user)
    {
        Auth::user()->following()->detach($user->id);

        return back()->with('success', 'Вы успешно отписались от ' . $user->name);
    }
}