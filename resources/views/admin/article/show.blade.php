<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6">
                    <h1
                        class="inline-block text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                        {{ __('Show article') }}</h1>
                    <a href="{{ route('article.index') }}"
                        class="no-underline hover:underline text-cyan-600 dark:text-cyan-400">{{ __('<< Back to all articles') }}</a>
                    @if ($errors->any())
                        <ul class="mt-3 list-none list-inside text-sm text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="w-full px-6 py-4 bg-white overflow-hidden">
                    <div method="POST" action="{{ route('article.update', $article->id) }}">
                        <div class="py-2">
                            <label for="caption"
                                class="block font-medium text-sm text-gray-700{{ $errors->has('caption') ? ' text-red-400' : '' }}">{{ __('Caption') }}</label>
                            <input id="caption"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full{{ $errors->has('caption') ? ' border-red-400' : '' }}"
                                type="text" disabled value="{{ old('caption', $article->caption) }}" />
                        </div>
                        <div class="py-2">
                            <label for="author"
                                class="block font-medium text-sm text-gray-700{{ $errors->has('author') ? ' text-red-400' : '' }}">{{ __('Author') }}</label>
                            <input id="author" disabled
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full{{ $errors->has('author') ? ' border-red-400' : '' }}"
                                type="text" disabled value="{{ old('author', $article->authorInfo->name) }}" />
                        </div>
                        <div class="py-2">
                            <label for="detail"
                                class="block py-2 font-medium text-sm text-gray-700{{ $errors->has('detail') ? ' text-red-400' : '' }}">{{ __('Detail') }}</label>
                            <div>{!! $article->detail !!}</div>
                        </div>
                        <div class="py-2">
                            <label for="image"
                                class="block font-medium text-sm text-gray-700{{ $errors->has('image') ? ' text-red-400' : '' }}">{{ __('Image') }}</label>
                            <div class="input-group flex flex-col" id="img2b64">
                                <div class="mt-4">
                                    <img id="img-preview" src="{{ $article->image_url }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <h3
                                class="inline-block text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                                Categories</h3>
                            <div class="grid grid-cols-4 gap-4">
                                <x-forms.checkbox id="1" name="categories[]" :items="$categories" :selected="$articleHasCategories" />
                            </div>
                            <h3
                                class="inline-block text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                                Tags</h3>
                            <div class="grid grid-cols-4 gap-4">
                                <x-forms.checkbox id="1" name="tags[]" :items="$tags" :selected="$articleHasTags" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
