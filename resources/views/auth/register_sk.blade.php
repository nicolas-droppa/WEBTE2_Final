@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-16 mb-20 px-6">
        <div class="bg-white dark:bg-[#1c1c1e] rounded-xl shadow-md p-8 border border-slate-200 dark:border-[#141414]">
            <h2 class="text-3xl font-bold mb-6 text-slate-800 dark:text-white text-center">
                <i class="fas fa-user-plus text-[#54b5ff] mr-2"></i> {{ __('Registrácia') }}
            </h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Meno -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">{{ __('Meno') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-2 rounded-md bg-gray-100 border border-gray-300 dark:bg-[#2a2a2a] dark:border-[#333] dark:text-white focus:outline-none focus:ring-2 focus:ring-[#54b5ff]">
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 rounded-md bg-gray-100 border border-gray-300 dark:bg-[#2a2a2a] dark:border-[#333] dark:text-white focus:outline-none focus:ring-2 focus:ring-[#54b5ff]">
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Heslo -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">{{ __('Heslo') }}</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 rounded-md bg-gray-100 border border-gray-300 dark:bg-[#2a2a2a] dark:border-[#333] dark:text-white focus:outline-none focus:ring-2 focus:ring-[#54b5ff]">
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Potvrdenie hesla -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">{{ __('Potvrďte heslo') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 py-2 rounded-md bg-gray-100 border border-gray-300 dark:bg-[#2a2a2a] dark:border-[#333] dark:text-white focus:outline-none focus:ring-2 focus:ring-[#54b5ff]">
                    @error('password_confirmation')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Akcie -->
                <div class="flex flex-col items-center justify-between mt-6">
                    <a href="{{ route('login.' . app()->getLocale()) }}" class="text-[#54b5ff] hover:underline text-sm mb-4">
                        {{ __('Už máte účet?') }}
                    </a>

                    <button type="submit"
                            class="w-full py-2 px-4 bg-[#54b5ff] text-white font-semibold rounded-md hover:bg-[#45a6e2] transition duration-300">
                        {{ __('Registrovať sa') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
