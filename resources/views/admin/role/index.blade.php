<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col mt-8">
                        @can('role create')
                            <div class="d-print-none with-border mb-8">
                                <a href="{{ route('role.create') }}"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('Add Role') }}</a>
                            </div>
                        @endcan
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
                                                NAME
                                            </th>
                                            @canany(['role edit', 'role delete'])
                                                <th
                                                    class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light text-left">
                                                    {{ __('Actions') }}
                                                </th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800">
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td
                                                    class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                    <div class="text-sm text-gray-900">
                                                        <a href="{{ route('role.show', $role->id) }}"
                                                            class="no-underline hover:underline text-cyan-600 dark:text-cyan-400">{{ $role->name }}</a>
                                                    </div>
                                                </td>

                                                <td
                                                    class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                                    @canany(['role edit', 'role delete'])
                                                        @if ($role->id !== 1)
                                                            <form action="{{ route('role.destroy', $role->id) }}"
                                                                method="POST">
                                                                @can('role edit')
                                                                    <a href="{{ route('role.edit', $role->id) }}"
                                                                        class="px-4 py-2 text-white mr-4 bg-blue-600">
                                                                        {{ __('Edit') }}
                                                                    </a>
                                                                @endcan
                                                                @can('role delete')
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="px-4 py-2 text-white bg-red-600"
                                                                        onclick="return confirm('{{ __('Xác nhận xoá?') }}')">
                                                                        {{ __('Delete') }}
                                                                    </button>
                                                                @endcan
                                                            </form>
                                                        @endif
                                                    @endcanany
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                $('#table_id').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>
