<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        // Загружаем только публичные посты, связанные с этим тегом
        $posts = $tag->posts()
                     ->where('status', 'public')
                     ->with('user', 'tags')
                     ->latest()
                     ->get();

        return view('tags.show', compact('tag', 'posts'));
    }
}