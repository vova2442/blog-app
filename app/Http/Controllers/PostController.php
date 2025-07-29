<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function show(Post $post)
    {
        // Загружаем пост со всеми его связями (автор, теги, комментарии и авторы комментариев)
        // Это делается один раз перед всеми проверками, чтобы избежать проблемы N+1.
        $post->load(['user', 'tags', 'comments.user']);

        if ($post->status === 'public' || $post->status === 'unlisted') {
            return view('posts.show', ['post' => $post]);
        }
        if ($post->status === 'private') {
            if (Auth::check() && Auth::id() === $post->user_id) {
                return view('posts.show', ['post' => $post]);
            }
        }
        abort(403);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'status' => ['required', Rule::in(['public', 'unlisted', 'private'])],
            'tags' => 'nullable|string',
        ]);
        $validated['user_id'] = Auth::id();

        $tags_string = $validated['tags'] ?? '';
        unset($validated['tags']);

        $post = Post::create($validated);
        $this->syncTags($post, $tags_string);

        return redirect()->route('dashboard')->with('success', 'Пост успешно создан!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'status' => ['required', Rule::in(['public', 'unlisted', 'private'])],
            'tags' => 'nullable|string',
        ]);

        $tags_string = $validated['tags'] ?? '';
        unset($validated['tags']);

        $post->update($validated);
        $this->syncTags($post, $tags_string);

        return redirect()->route('posts.show', $post)->with('success', 'Пост успешно обновлен!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('dashboard')->with('success', 'Пост успешно удален!');
    }

    public function feed()
    {
        $followedUserIds = Auth::user()->following()->pluck('users.id');
        $posts = Post::whereIn('user_id', $followedUserIds)
                     ->where('status', 'public')
                     ->with('user', 'tags') // Загружаем теги
                     ->latest()
                     ->get();
        return view('posts.feed', ['posts' => $posts]);
    }

    /**
     * Вспомогательный метод для синхронизации тегов.
     */
    private function syncTags(Post $post, ?string $tags_string): void
    {
        if (is_null($tags_string)) {
            $post->tags()->sync([]);
            return;
        }

        $tagNames = array_filter(array_map('trim', explode(',', $tags_string)));
        $tagIds = [];
        foreach ($tagNames as $tagName) {
            $tag = Tag::firstOrCreate(['name' => strtolower($tagName)]);
            $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);
    }
}