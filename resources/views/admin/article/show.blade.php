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
                            <div><?php echo $article->detail; ?></div>
                        </div>
                        <div class="py-2">
                            <label for="image"
                                class="block font-medium text-sm text-gray-700{{ $errors->has('image') ? ' text-red-400' : '' }}">{{ __('Image') }}</label>
                            <div class="input-group flex flex-row" id="img2b64">
                                <div class="output mt-4">
                                    <img src="{{ old('image', $article->image) }}" style="max-height: 250px">
                                </div>
                            </div>
                            <div class="py-2">
                                <h3
                                    class="inline-block text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                                    Categories</h3>
                                <div class="grid grid-cols-4 gap-4">
                                    @forelse ($categories as $category)
                                        <div class="col-span-4 sm:col-span-2 md:col-span-1">
                                            <label class="form-check-label">
                                                <input type="checkbox" disabled value="{{ $category->name }}"
                                                    {{ in_array($category->id, $articleHasCategories) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    @empty
                                        ----
                                    @endforelse
                                </div>
                                <h3
                                    class="inline-block text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                                    Tags</h3>
                                <div class="grid grid-cols-4 gap-4">
                                    @forelse ($tags as $tag)
                                        <div class="col-span-4 sm:col-span-2 md:col-span-1">
                                            <label class="form-check-label">
                                                <input type="checkbox" disabled value="{{ $tag->name }}"
                                                    {{ in_array($tag->id, $articleHasTags) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                {{ $tag->name }}
                                            </label>
                                        </div>
                                    @empty
                                        ----
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
