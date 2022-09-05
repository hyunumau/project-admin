<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col mt-8">
                        <div class="d-print-none with-border mb-8">
                            <a href="{{ route('article.create') }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Add Article') }}</a>
                        </div>
                        <form>
                            <div class="flex flex-row">
                                <div class="basic 3/12 px-2 pt-3">
                                    <label>Categories</label>
                                </div>
                                <div class="basic 1/12 w-1/2 mt-2">
                                    <select class="js-example-basic-multiple w-full" name="categories[]"
                                        multiple="multiple" id="select-filter" >
                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @if (in_array($category->id, request('categories', []))) selected @endif
                                            >
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="basic 5/12 px-4 w-3/12">
                                    <x-forms.input 
                                    type="search" 
                                    name="search" 
                                    placeholder="Caption, ID and Author" 
                                    value="{{ request('search') }}"
                                    />
                                </div>
                                <div class="basic 3/12 px-4 mt-2">
                                    <button type="submit" class="px-4 mb-1 py-1 text-white bg-green-500 rounded">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="py-2">
                            @if (session()->has('message'))
                                <div class="mb-8 text-green-400 font-bold">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="min-w-full border-b border-gray-200 shadow">
                                <table class="border-collapse table-auto w-full text-sm" id="table_id">
                                    <thead>
                                        <tr>
                                            <th
                                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left">
                                                ID
                                            </th>
                                            <th
                                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left">
                                                CAPTION
                                            </th>
                                            <th
                                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left">
                                                AUTHOR
                                            </th>
                                            <th
                                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left">
                                                CATEGORIES
                                            </th>
                                            <th
                                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left">
                                                PUBLISH
                                            </th>
                                            <th
                                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left  w-1/4">
                                                IMAGE URL
                                            </th>
                                            <th
                                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left w-1/5">
                                                {{ __('Actions') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800">
                                        @foreach ($articles as $article)
                                            <tr>
                                                <td
                                                    class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                    <div class="text-sm text-gray-900">
                                                        <a style="color:blue"
                                                            href="{{ route('article.show', $article->id) }}">{{ $article->id }}</a>
                                                    </div>
                                                </td>
                                                <td
                                                    class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                    <div class="text-sm text-gray-900">
                                                        {{ $article->caption }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                    <div class="text-sm text-gray-900">
                                                        {{ $article->authorInfo->name }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                    <div class="text-sm text-gray-900">
                                                        @foreach ($article->categories as $key => $category)
                                                            {{ $key === 0 ? null : ', ' }} {{ $category->name }}
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td
                                                    class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                    <div class="text-sm text-gray-900">
                                                        @if ($article->publish)
                                                            <a href="{{ route('article.change-publish', $article->id) }}"
                                                                class="attachment-upload px-4 py-2 text-white mr-4 bg-green-600">Publish</a>
                                                        @else
                                                            <a href="{{ route('article.change-publish', $article->id) }}"
                                                                class="attachment-upload px-4 py-2 text-white mr-4 bg-yellow-600">Unpublish</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td
                                                    class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                    <div class="text-sm text-gray-900">
                                                        <img src="{{ $article->image_url }}" />
                                                    </div>
                                                </td>
                                                @if ($authoredit->is_superadmin)
                                                    <td
                                                        class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                        <form action="{{ route('article.destroy', $article->id) }}"
                                                            method="POST">
                                                            <a href="{{ route('article.edit', $article->id) }}"
                                                                class="px-4 py-2 text-white mr-4 bg-blue-600">
                                                                {{ __('Edit') }}
                                                            </a>
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="px-4 py-2 text-white bg-red-600"
                                                                onclick="return confirm('{{ __('Xác nhận xoá?') }}')">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td
                                                        class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                        @if ($article->author == $authoredit->id)
                                                            <form action="{{ route('article.destroy', $article->id) }}"
                                                                method="POST">
                                                                <a href="{{ route('article.edit', $article->id) }}"
                                                                    class="px-4 py-2 text-white mr-4 bg-blue-600">
                                                                    {{ __('Edit') }}
                                                                </a>
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="px-4 py-2 text-white bg-red-600"
                                                                    onclick="return confirm('{{ __('Xác nhận xoá?') }}')">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="py-8">
                                {{ $articles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $('#table_id').DataTable({
                    "pagingType": "input",
                    paging: false,
                    info: false,
                    "searching": false
                });

                $('.js-example-basic-multiple').select2();
            });
        </script>
    </x-slot>
</x-app-layout>
