@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-[#1c1c1e] p-6 rounded-2xl shadow-md border border-gray-200 dark:border-[#292929] mt-10 space-y-6">

    <div>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">
            {{ __('test.result_title') }}: {{ $history->test->title }}
        </h2>
        <p class="text-slate-700 dark:text-slate-300"><strong>{{ __('test.score') }}:</strong> {{ $score }} / {{ $history->questions->count() }}</p>
        <p class="text-slate-700 dark:text-slate-300"><strong>{{ __('test.total_time') }}:</strong> {{ $totalTime }} {{ __('test.seconds') }}</p>
        <p class="text-slate-700 dark:text-slate-300"><strong>{{ __('test.avg_time') }}:</strong> {{ $averageTime }} {{ __('test.seconds') }}</p>
    </div>

    <div class="space-y-4">
        @foreach($history->questions as $question)
        <div class="p-4 border border-slate-300 dark:border-[#292929] rounded-lg bg-slate-50 dark:bg-[#2a2a2a] space-y-2">
            <h3 class="text-slate-800 dark:text-white font-semibold">
                {!! '$' . $question->{'assignment_' . app()->getLocale()} . '$' !!}
            </h3>

            <p class="text-sm text-slate-700 dark:text-slate-300">
                <strong>{{ __('test.your_answer') }}:</strong>
                @if($question->pivot->answer_id)
                    {!! '$' . ($question->answers->firstWhere('id', $question->pivot->answer_id)?->{'answer_' . app()->getLocale()} ?? '-') . '$' !!}
                @else
                    {!! '$' . ($question->pivot->written_answer ?? '-') . '$' !!}
                @endif
            </p>

            <p class="text-sm text-green-700 dark:text-green-400">
                <strong>{{ __('test.correct_answer') }}:</strong>
                {!! '$' . ($question->correctAnswer?->{'answer_' . app()->getLocale()} ?? 'N/A') . '$' !!}
            </p>

            <p class="text-sm text-slate-600 dark:text-slate-400">
                <strong>{{ __('test.time_spent') }}:</strong> {{ $question->pivot->time }} {{ __('test.seconds') }}
            </p>
        </div>
        @endforeach
    </div>

    <div class="pt-6">
        <a href="{{ route('test.index') }}"
           class="inline-block bg-[#54b5ff] hover:bg-[#3ca5ec] text-white font-semibold px-6 py-2 rounded-md transition shadow">
            <i class="fas fa-arrow-left mr-2"></i> {{ __('test.back_to_tests') }}
        </a>
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
    });"></script>
@endsection
