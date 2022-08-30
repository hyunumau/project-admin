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
                </div>
                <div class="w-full px-6 py-4 bg-white overflow-hidden">
                    <form method="POST" action="{{ route('article.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="py-2">
                            <x-forms.input name="caption" required="true" label="{{ __('Caption') }}" />
                        </div>
                        <div class="py-2">
                            <x-forms.input type="textarea" name="detail" required="true" label="{{ __('Detail') }}" />
                        </div>
                        <div class="py-2">
                            <label for="image"
                                class="block font-medium text-sm text-gray-700{{ $errors->has('image') ? ' text-red-400' : '' }}">{{ __('Image') }}</label>
                            <div class="input-group flex flex-col" id="img2b64">
                                <div class="border-dashed rounded border-grey-400 border-2 p-2">
                                    <x-forms.input type="file" name="image" required="true" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <img id="img-preview" />
                            </div>
                        </div>
                        <div class="py-2">
                            <h3
                                class="inline-block text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                                Categories</h3>
                            <div class="grid grid-cols-4 gap-4">
                                <x-forms.checkbox id="1" name="categories[]" :items="$categories" :selected="[]" />
                            </div>
                            <h3
                                class="inline-block text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                                Tags</h3>
                            <div class="grid grid-cols-4 gap-4">
                                <x-forms.checkbox id="1" name="tags[]" :items="$tags" :selected="[]" />
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
            $('input[name="image"]').on('change', function() {
                $('#img-preview').attr('src', '');
                const file = this.files[0];
                const reader = new FileReader();
                reader.onloadend = function() {
                    $('#img-preview').attr('src', reader.result);
                };
                if (file) {
                    reader.readAsDataURL(file);
                }
            })
        </script>
    </x-slot>
    
</x-app-layout>
