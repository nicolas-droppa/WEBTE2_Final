@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 mb-20">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white mb-6">
        <i class="fas fa-question-circle text-[#54b5ff] mr-2"></i> {{ __('history.question-detail-heading') }}
    </h1>
@php
    $lang = app()->getLocale();
    $testCount = $question->tests->count();
    $correctCount = $question->tests->where('pivot.isCorrect', true)->count();
    $avgTime = $question->tests->avg('pivot.time');
@endphp

<div class="bg-white dark:bg-[#1c1c1e] p-6 rounded-lg border border-slate-200 dark:border-[#141414] shadow mb-6">
    <h2 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">
        {{ __('history.question-statistics') }}
    </h2>
    <div class="flex flex-col sm:flex-row gap-6 text-sm text-slate-600 dark:text-slate-300">
        <div class="flex-1">
            <p class="mb-1">{{ __('history.question-count') }}</p>
            <p class="text-xl font-bold text-slate-900 dark:text-white">{{ $testCount }}</p>
        </div>
        <div class="flex-1">
            <p class="mb-1">{{ __('history.question-success-rate') }}</p>
            <p class="text-xl font-bold text-slate-900 dark:text-white">
                {{ $testCount ? round(($correctCount / $testCount) * 100) : 0 }} %
            </p>
        </div>
        <div class="flex-1">
            <p class="mb-1">{{ __('history.question-avg-time') }}</p>
            <p class="text-xl font-bold text-slate-900 dark:text-white">
                {{ $avgTime ? round($avgTime, 2) . ' s' : '-' }}
            </p>
        </div>
    </div>
</div>
    {{-- Assignment --}}
    <div class="bg-white dark:bg-[#1c1c1e] shadow-md rounded-xl p-6 border border-slate-200 dark:border-[#141414] mb-6">
        <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-2">
            {{ __('history.question-assignment') }}
        </p>
        <p class="text-slate-700 dark:text-slate-300 italic">
            {!! '$' . $question->{'assignment_' . $lang} . '$' !!}
        </p>

        {{-- Tags --}}
        @if ($question->tags->isNotEmpty())
            <div class="mt-4">
                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-2">
                    {{ __('history.question-tags') }}
                </p>
                <ul class="flex flex-wrap gap-2">
                    @foreach ($question->tags as $tag)
                        <li class="text-xs font-medium px-3 py-1 rounded-full border border-[#54b5ff]
                            bg-[#e6f4ff] dark:bg-[#133c4d] text-[#1e4b6d] dark:text-[#8bd4ff]">
                            {{ $tag->{'name_' . app()->getLocale()} }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Answers --}}
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach ($question->answers as $answer)
                <div class="flex items-start gap-2 p-3 rounded-lg
                    {{ $answer->isCorrect ? 'bg-green-100 dark:bg-green-900/30' : 'bg-slate-50 dark:bg-[#2a2a2a]' }}">
                    <span class="text-slate-800 dark:text-slate-100 text-sm">
                        {!! '$' . $answer->answer . '$' !!}
                    </span>
                    @if($answer->isCorrect)
                        <i class="fas fa-check text-green-600 mt-0.5"></i>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</div>




@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/katex.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/contrib/auto-render.min.js"
        onload="renderMathInElement(document.body, {
            delimiters: [
                {left: '$$', right: '$$', display: true},
                {left: '$', right: '$', display: false}
            ]
        });">
</script>
@endsection
