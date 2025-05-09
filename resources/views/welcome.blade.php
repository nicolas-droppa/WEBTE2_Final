@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-16 mb-20 px-6">
        <h1 class="text-4xl font-bold mb-6 text-slate-800 dark:text-gray-100">{{ __('welcome.welcome_title') }}</h1>
        <p class="text-lg text-slate-600 dark:text-gray-300 mb-10">
            {{ __('welcome.welcome_text') }}
        </p>

        <div class="bg-white dark:bg-[#1c1c1e] rounded-xl shadow-md p-8 space-y-8 border border-slate-200 dark:border-[#141414]">
            @include('manual.manual')
            
            <div class="pt-4">
                <p class="text-base text-slate-600 dark:text-gray-400">
                    {{ __('welcome.ready') }} <span class="font-semibold text-[#54b5ff] dark:text-[#54b5ff]">{{ __('welcome.start_training') }}</span>
                </p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('manual.download') }}"
                class="text-gray-500 pt-2 pr-4 text-xs font-semibold">
                    <i class="fas fa-download mr-1"></i> {{ __('welcome.download_pdf') }}
                </a>
            </div>
        </div>
    </div>
@endsection
