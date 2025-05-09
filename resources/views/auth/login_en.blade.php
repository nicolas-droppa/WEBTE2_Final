@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-16 mb-20 px-6">
        <div class="bg-white dark:bg-[#1c1c1e] rounded-xl shadow-md p-8 border border-slate-200 dark:border-[#141414]">
            <h2 class="text-3xl font-bold mb-6 text-slate-800 dark:text-white text-center">
                <i class="fas fa-sign-in-alt text-[#54b5ff] mr-2"></i> Login
            </h2>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2 rounded-md bg-gray-100 border border-gray-300 dark:bg-[#2a2a2a] dark:border-[#333] dark:text-white focus:outline-none focus:ring-2 focus:ring-[#54b5ff]">
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 rounded-md bg-gray-100 border border-gray-300 dark:bg-[#2a2a2a] dark:border-[#333] dark:text-white focus:outline-none focus:ring-2 focus:ring-[#54b5ff]">
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-4">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-[#54b5ff] shadow-sm focus:ring-[#54b5ff] dark:bg-[#2a2a2a]">
                    <label for="remember_me" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Remember me</label>
                </div>

                <!-- Forgot Password & Register -->
                <div class="flex justify-between items-center mb-6 text-sm">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-[#54b5ff] hover:underline">Forgot your password?</a>
                    @endif
                    @if (Route::has('register.' . app()->getLocale()))
                        <a href="{{ route('register.' . app()->getLocale()) }}" class="text-[#54b5ff] hover:underline">
                            {{ __("Don't have an account?") }}
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full py-2 px-4 bg-[#54b5ff] text-white font-semibold rounded-md hover:bg-[#45a6e2] transition duration-300">
                    Log in
                </button>
            </form>
        </div>
    </div>
@endsection
