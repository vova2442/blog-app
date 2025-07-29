<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Посты с тегом: <span class="px-2 py-1 bg-blue-200 text-blue-800 rounded-md">{{ $tag->name }}</span>
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
                        <!-- Блок с тегами -->
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($post->tags as $tag_item)
                                <a href="{{ route('tags.show', $tag_item) }}" class="px-2 py-1 bg-gray-200 text-gray-800 text-sm rounded-md hover:bg-gray-300">
                                    #{{ $tag_item->name }}
                                </a>
                            @endforeach
                        </div>
                        <p class="mt-4">{{ Str::limit($post->body, 300) }}</p>
                    </div>
                </div>
            @empty
                <p>Пока что нет ни одного поста с этим тегом.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>