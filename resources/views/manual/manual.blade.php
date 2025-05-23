<h2 class="text-2xl font-semibold text-[#54b5ff] dark:text-[#54b5ff] border-b pb-2 dark:border-[#141414] manual-h2">
    <i class="fas fa-compass mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
    <img class="pdf-export-only manual-img"
        src="{{ isset($pdf) && $pdf ? public_path('icons/compass-solid.svg') : asset('icons/compass-solid.svg') }}"
        width="20" height="20"
    >
    {{ __('welcome.how_to_use') }}
</h2>

<section class="space-y-2">
    <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
        <i class="fas fa-globe mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
        <img class="pdf-export-only manual-img"
            src="{{ isset($pdf) && $pdf ? public_path('icons/globe-solid.svg') : asset('icons/globe-solid.svg') }}"
            width="20" height="20"
        >
        {{ __('welcome.switch_language') }}
    </h3>
    <p class="text-slate-700 dark:text-gray-400">
        {{ __('welcome.switch_language_description') }}
    </p>
</section>

<section class="space-y-2">
    <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
        <i class="fas fa-question-circle mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
        <img class="pdf-export-only manual-img"
            src="{{ isset($pdf) && $pdf ? public_path('icons/question-circle-solid.svg') : asset('icons/question-circle-solid.svg') }}"
            width="20" height="20"
        >
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
        <img class="pdf-export-only manual-img"
            src="{{ isset($pdf) && $pdf ? public_path('icons/stopwatch-solid.svg') : asset('icons/stopwatch-solid.svg') }}"
            width="20" height="20"
        >
        {{ __('welcome.time_limit') }}
    </h3>
    <p class="text-slate-700 dark:text-gray-400">
        {{ __('welcome.time_limit_description') }}
    </p>
</section>

<section class="space-y-2">
    <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
        <i class="fas fa-unlock-alt mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
        <img class="pdf-export-only manual-img"
            src="{{ isset($pdf) && $pdf ? public_path('icons/unlock-alt-solid.svg') : asset('icons/unlock-alt-solid.svg') }}"
            width="20" height="20"
        >
        {{ __('welcome.no_registration') }}
    </h3>
    <p class="text-slate-700 dark:text-gray-400">
        {{ __('welcome.no_registration_description') }}
    </p>
</section>

<section class="space-y-2">
    <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
        <i class="fas fa-chart-bar mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
        <img class="pdf-export-only manual-img"
            src="{{ isset($pdf) && $pdf ? public_path('icons/chart-bar-solid.svg') : asset('icons/chart-bar-solid.svg') }}"
            width="20" height="20"
        >
        {{ __('welcome.results_and_recommendations') }}
    </h3>
    <ul class="list-disc list-inside text-slate-700 dark:text-gray-400 space-y-1">
        @foreach (__('welcome.results_and_recommendations_description') as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
</section>

<style>
    @font-face {
    font-family: 'Open Sans';
    src: url({{ ($pdf ?? false) ? public_path('fonts/OpenSans.ttf') : asset('fonts/OpenSans.ttf') }}) format('truetype');
    font-weight: normal;
    font-style: normal;
}

    .pdf-export-only {
        display: none;
    }

    .manual-h2 {
        color: #54b5ff;
    }
</style>
