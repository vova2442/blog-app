<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Сохранить новый комментарий к посту.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:2500', // Комментарий обязателен, не более 2500 символов
        ]);

        // Создаем комментарий, связывая его с постом и текущим пользователем
        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
        ]);

        // Возвращаем пользователя обратно на страницу поста
        return back()->with('success', 'Комментарий успешно добавлен!');
    }
}