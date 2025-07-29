<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Профиль пользователя: ') }} {{ $user->name }}
            </h2>

            @auth
                @if(Auth::id() !== $user->id)
                    @if ($isFollowing)
                        <form method="POST" action="{{ route('users.unfollow', $user) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Отписаться
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('users.follow', $user) }}">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Подписаться
                            </button>
                        </form>
                    @endif
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="text-2xl font-bold mb-4">Посты пользователя</h3>

            <!-- ИСПРАВЛЕНИЕ: Используем переменную $posts, а не $user->posts -->
            @forelse($posts as $post)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900">
                        <a href="{{ route('posts.show', $post) }}">
                            <h4 class="text-xl font-bold text-blue-500 hover:text-blue-600">{{ $post->title }}</h4>
                        </a>
                        <p class="text-sm text-gray-500">Опубликовано: {{ $post->created_at->format('d.m.Y') }}</p>
                        <p class="mt-4">{{ Str::limit($post->body, 200) }}</p>
                    </div>
                </div>
            @empty
                <p>У этого пользователя еще нет публичных постов.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>