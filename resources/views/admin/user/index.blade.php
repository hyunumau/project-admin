<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col mt-8">
                        @can('user create')
                            <div class="d-print-none with-border mb-8">
                                <a href="{{ route('user.create') }}"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Add User') }}</a>
                            </div>
                        @endcan
                        <div class="py-2">
                            @if (session()->has('message'))
                                <div class="mb-8 text-green-400 font-bold">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="min-w-full border-b border-gray-200 shadow">
                                <table class="border-collapse table-auto w-full text-sm">
                                    <thead>
                                        <tr>
                                            <th
                                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left">
                                                NAME
                                            </th>
                                            <th
                                                class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left">
                                                EMAIL
                                            </th>
                                            @canany(['user edit', 'user delete'])
                                                <th
                                                    class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left">
                                                    {{ __('Actions') }}
                                                </th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800">
                                        @foreach ($users as $user)
                                            @if (!$user->is_superadmin)
                                                <tr>
                                                    <td
                                                        class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                        <div class="text-sm text-gray-900">
                                                            <a href="{{ route('user.show', $user->id) }}"
                                                                class="no-underline hover:underline text-cyan-600 dark:text-cyan-400">{{ $user->name }}</a>
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                        <div class="text-sm text-gray-900">
                                                            {{ $user->email }}
                                                        </div>
                                                    </td>
                                                    @canany(['user edit', 'user delete'])
                                                        <td 
                                                            class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                            <form action="{{ route('user.destroy', $user->id) }}"
                                                                method="POST">
                                                                @can('user edit')
                                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                                        class="px-4 py-2 text-white mr-4 bg-blue-600">
                                                                        {{ __('Edit') }}
                                                                    </a>
                                                                @endcan
                                                                @can('user delete')
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="px-4 py-2 text-white bg-red-600"
                                                                        onclick="return confirm('{{ __('Xác nhận xoá?') }}')">
                                                                        {{ __('Delete') }}
                                                                    </button>
                                                                @endcan
                                                            </form>
                                                        </td>
                                                    @endcanany
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="py-8">
                                {{ $users->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
