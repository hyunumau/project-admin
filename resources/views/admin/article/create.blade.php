<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>
    @if (session('error'))
        <div class="mb-8 text-green-400 font-bold">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6">
                    <h1
                        class="inline-block text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                        {{ __('Create article') }}</h1>
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
                    <form method="POST" action="{{ route('article.store') }}">
                        @csrf
                        <div class="py-2">
                            <label for="caption"
                                class="block font-medium text-sm text-gray-700{{ $errors->has('caption') ? ' text-red-400' : '' }}">{{ __('Caption') }}</label>
                            <input id="caption"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full{{ $errors->has('caption') ? ' border-red-400' : '' }}"
                                type="text" name="caption" />
                        </div>
                        <div class="py-2">
                            <label for="detail"
                                class="block font-medium text-sm text-gray-700{{ $errors->has('detail') ? ' text-red-400' : '' }}">{{ __('Detail') }}</label>
                            <textarea name="detail" id="detail" cols="30" rows="10"></textarea>
                        </div>
                        <div class="py-2">
                            <label for="image"
                                class="block font-medium text-sm text-gray-700{{ $errors->has('image') ? ' text-red-400' : '' }}">{{ __('Image') }}</label>
                            <div class="input-group flex flex-row" id="img2b64">
                                <div class="basis-3/4">
                                    <input type="url"
                                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full{{ $errors->has('image') ? ' border-red-400' : '' }}"
                                        placeholder="Insert an IMAGE-URL" value="" type="text" name="image"
                                        required>
                                </div>
                                <button id="btn-load"
                                    class="mx-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Load</button>
                            </div>
                            <div class="output mt-4">
                                <img style="max-height: 250px">
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
                                            <input type="checkbox" name="categories[]" value="{{ $category->name }}"
                                                class="roundZed border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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
                                            <input type="checkbox" name="tags[]" value="{{ $tag->name }}"
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
                <div class="flex justify-end m-4">
                    <button type='submit'
                        class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>
                        {{ __('Create') }}
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <x-slot name="scripts">
        <script>
            ClassicEditor
                .create(document.querySelector('#detail'))
                .catch(error => {
                    console.error(error);
                });

            function convertImgToBase64(url, callback, outputFormat) {
                var canvas = document.createElement('CANVAS');
                var ctx = canvas.getContext('2d');
                var img = new Image;
                img.crossOrigin = 'Anonymous';
                img.onload = function() {
                    canvas.height = img.height;
                    canvas.width = img.width;
                    ctx.drawImage(img, 0, 0);
                    var dataURL = canvas.toDataURL(outputFormat || 'image/png');
                    callback.call(this, dataURL);
                    // Clean up
                    canvas = null;
                };
                img.src = url;
            }

            $('#btn-load').click(function(event) {
                var imageUrl = $('#img2b64').find('input[name=image]').val();
                convertImgToBase64(imageUrl, function(base64Img) {
                    $('.output')
                        .find('textarea')
                        .val(base64Img)
                        .end()
                        .find('a')
                        .attr('href', base64Img)
                        .text(base64Img)
                        .end()
                        .find('img')
                        .attr('src', base64Img);
                });
                event.preventDefault()
            });
        </script>
    </x-slot>
</x-app-layout>
