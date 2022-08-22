<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6">
                    <h1
                        class="inline-block text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                        {{ __('Create user') }}</h1>
                    <a href="{{ route('user.index') }}"
                        class="no-underline hover:underline text-cyan-600 dark:text-cyan-400">{{ __('<< Back to all users') }}</a>
                </div>
                <div class="w-full px-6 py-4 bg-white overflow-hidden">
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="py-2">
                            <x-forms.input name="name" required="true" label="{{ __('Name') }}" value="{{ old('name') }}"/>
                        </div>
                        <div class="py-2">
                            <x-forms.input type="email" name="email" required="true" label="{{ __('Email') }}" value="{{ old('email') }}"/>
                        </div>
                        <div class="py-2">
                            <x-forms.input type="password" name="password" required="true" label="{{ __('Password') }}" value="{{ old('password') }}"/>
                        </div>
                        <div class="py-2">
                            <x-forms.input type="password" name="password_confirmation" required="true" label="{{ __('Password Confirmation') }}" value="{{ old('password_confirmation') }}"/>
                        </div>
                        <div class="py-2">
                            <h3
                                class="inline-block text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">
                                Roles</h3>
                            <div class="grid grid-cols-4 gap-4">
                                <x-forms.checkbox id="1" name="roles[]" :items="$roles" :selected="[]" />
                            </div>
                        </div>
                        <div class="flex justify-end mt-4">
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
</x-app-layout>
