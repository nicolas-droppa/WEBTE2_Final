@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-16 mb-20 px-6">
        <h1 class="text-4xl font-bold mb-6 text-slate-800 dark:text-gray-100">{{ __('welcome.welcome_title') }}</h1>
        <p class="text-lg text-slate-600 dark:text-gray-300 mb-10">
            {{ __('welcome.welcome_text') }}
        </p>

        <div class="bg-white dark:bg-[#1c1c1e] rounded-xl shadow-md p-8 space-y-8 border border-slate-200 dark:border-[#141414]">
            <h2 class="text-2xl font-semibold text-[#54b5ff] dark:text-[#54b5ff] border-b pb-2 dark:border-[#141414]">
                <i class="fas fa-compass mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                {{ __('welcome.how_to_use') }}
            </h2>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-globe mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    {{ __('welcome.switch_language') }}
                </h3>
                <p class="text-slate-700 dark:text-gray-400">
                    {{ __('welcome.switch_language_description') }}
                </p>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-question-circle mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    {{ __('welcome.question_types') }}
                </h3>
                <ul class="list-disc list-inside text-slate-700 dark:text-gray-400 space-y-1">
                    @foreach (__('welcome.question_types_description') as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-stopwatch mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    {{ __('welcome.time_limit') }}
                </h3>
                <p class="text-slate-700 dark:text-gray-400">
                    {{ __('welcome.time_limit_description') }}
                </p>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-unlock-alt mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    {{ __('welcome.no_registration') }}
                </h3>
                <p class="text-slate-700 dark:text-gray-400">
                    {{ __('welcome.no_registration_description') }}
                </p>
            </section>

            <section class="space-y-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                    <i class="fas fa-chart-bar mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    {{ __('welcome.results_and_recommendations') }}
                </h3>
                <ul class="list-disc list-inside text-slate-700 dark:text-gray-400 space-y-1">
                    @foreach (__('welcome.results_and_recommendations_description') as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </section>

            <div class="pt-4">
                <p class="text-base text-slate-600 dark:text-gray-400">
                    {{ __('welcome.ready') }} <span class="font-semibold text-[#54b5ff] dark:text-[#54b5ff]">{{ __('welcome.start_training') }}</span>
                </p>
            </div>
        </div>
    </div>
@endsection
