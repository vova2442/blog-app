<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Личный кабинет') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- НАЧАЛО МОЕГО ДОБАВЛЕННОГО БЛОКА -->
            <!-- Сообщение об успешном создании поста -->
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <!-- КОНЕЦ МОЕГО ДОБАВЛЕННОГО БЛОКА -->

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    <!-- НАЧАЛО МОЕГО ДОБАВЛЕННОГО БЛОКА -->
                    <!-- Кнопка/ссылка для создания поста -->
                    <div class="mt-4">
                        <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Создать новый пост
                        </a>
                    </div>
                    <!-- КОНЕЦ МОЕГО ДОБАВЛЕННОГО БЛОКА -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>