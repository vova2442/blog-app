<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование поста') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('posts.update', $post) }}">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="title">{{ __('Заголовок') }}</label>
                            <input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $post->title) }}" required autofocus />
                        </div>

                        <div class="mt-4">
                            <label for="body">{{ __('Текст поста') }}</label>
                            <textarea id="body" name="body" class="block mt-1 w-full" rows="10" required>{{ old('body', $post->body) }}</textarea>
                        </div>

                        <!-- Поле для тегов -->
                        <div class="mt-4">
                            <label for="tags">{{ __('Теги (через запятую)') }}</label>
                            <!-- $post->tags->pluck('name')->implode(', ') - получаем имена тегов поста и склеиваем их в строку -->
                            <input id="tags" class="block mt-1 w-full" type="text" name="tags" value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}" />
                        </div>

                        <div class="mt-4">
                            <label for="status">{{ __('Видимость поста') }}</label>
                            <select name="status" id="status" class="block mt-1 w-full">
                                <option value="public" @selected(old('status', $post->status) == 'public')>Публичный</option>
                                <option value="unlisted" @selected(old('status', $post->status) == 'unlisted')>По ссылке</option>
                                <option value="private" @selected(old('status', $post->status) == 'private')>Приватный</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Обновить') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>