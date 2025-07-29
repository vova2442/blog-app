<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Моя лента') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($posts as $post)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900">
                        <a href="{{ route('posts.show', $post) }}">
                            <h3 class="text-2xl font-bold text-blue-500 hover:text-blue-600">{{ $post->title }}</h3>
                        </a>
                        <p class="text-sm text-gray-500 mb-2">
                            Автор:
                            <a href="{{ route('users.show', $post->user) }}" class="text-blue-500 hover:underline">
                                {{ $post->user->name }}
                            </a>
                            | Опубликовано: {{ $post->created_at->format('d.m.Y') }}
                        </p>
                        <p>{{ Str::limit($post->body, 300) }}</p>
                    </div>
                </div>
            @empty
                <!-- Сообщение для пустой ленты -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                       <p>Ваша лента пока пуста.</p>
                       <p class="mt-2">Подпишитесь на интересных авторов на странице <a href="{{ route('home') }}" class="text-blue-500 hover:underline">"Все посты"</a>, и их публикации появятся здесь.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>