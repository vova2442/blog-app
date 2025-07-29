<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Блок с постом -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end space-x-2 mb-4">
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}" class="inline-block bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Редактировать</a>
                        @endcan
                        @can('delete', $post)
                            <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Вы уверены, что хотите удалить этот пост?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Удалить</button>
                            </form>
                        @endcan
                    </div>
                    <p class="text-sm text-gray-600 mb-2">
                        Автор:
                        <a href="{{ route('users.show', $post->user) }}" class="text-blue-500 hover:underline">
                            {{ $post->user->name }}
                        </a>
                        | Опубликовано: {{ $post->created_at->format('d.m.Y в H:i') }}
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('tags.show', $tag) }}" class="px-2 py-1 bg-gray-200 text-gray-800 text-sm rounded-md hover:bg-gray-300">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                    <div class="prose max-w-none">
                        {!! nl2br(e($post->body)) !!}
                    </div>
                </div>
            </div>

            <!-- Блок с комментариями -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Комментарии ({{ $post->comments->count() }})</h3>
                    
                    @auth
                        <form method="POST" action="{{ route('comments.store', $post) }}">
                            @csrf
                            <div class="mt-4">
                                <label for="body" class="sr-only">Ваш комментарий</label>
                                <textarea name="body" id="body" rows="4" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Оставьте свой комментарий..." required></textarea>
                            </div>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Отправить</button>
                            </div>
                        </form>
                    @else
                        <p>Чтобы оставить комментарий, пожалуйста, <a href="{{ route('login') }}" class="text-blue-500 hover:underline">войдите</a> или <a href="{{ route('register') }}" class="text-blue-500 hover:underline">зарегистрируйтесь</a>.</p>
                    @endauth

                    <!-- Список существующих комментариев (с исправленной версткой) -->
                    <div class="mt-6 space-y-6">
                        @forelse ($post->comments as $comment)
                            <div class="flex">
                                <div class="flex-shrink-0 mr-4"> <!-- Добавлен отступ справа -->
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-grow"> <!-- Этот блок теперь занимает оставшееся место -->
                                    <div class="font-bold">
                                        <a href="{{ route('users.show', $comment->user) }}" class="hover:underline">{{ $comment->user->name }}</a>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                    <p class="mt-2 text-gray-700">
                                        {{ $comment->body }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p>Пока что нет ни одного комментария. Станьте первым!</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>