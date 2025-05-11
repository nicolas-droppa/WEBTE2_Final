@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 mb-20">
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-slate-800 dark:text-gray-100">
            <i class="fas fa-file-alt mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
            {{ __('history.test-details-heading') }}
        </h1>
    </div>

    <!-- Test Info -->
    <div class="bg-white dark:bg-[#1c1c1e] shadow-md rounded-xl p-6 border border-slate-200 dark:border-[#141414] mb-10">
        <p class="text-slate-700 dark:text-slate-300">
            <strong>{{ __('history.user-name') }}: </strong> {{ $test->user->name }}
        </p>
        <p class="text-slate-700 dark:text-slate-300">
            <strong>{{ __('history.time') }}:</strong> {{ $test->created_at }}
        </p>
    </div>

    <!-- Questions -->
    @php $lang = app()->getLocale(); @endphp

    <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-100 mb-4">
        {{ __('history.questions-heading') }}
    </h2>

    @foreach ($test->questions as $question)
        <div class="bg-white dark:bg-[#1c1c1e] shadow-md rounded-xl p-6 mb-6 border border-slate-200 dark:border-[#141414] space-y-4">
            
            <!-- Assignment -->
            <div class="pl-3 border-l-4 border-[#54b5ff]">
                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-1">{{ __('history.question-assignment') }}</p>
                <p class="text-sm text-slate-700 dark:text-slate-300 italic">
                    {!! '$' . $question->{'assignment_' . $lang} . '$' !!}
                </p>
            </div>

            <!-- Tags -->
            @if ($question->tags->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    @foreach ($question->tags as $tag)
                        <span class="text-xs font-medium px-3 py-1 rounded-full border border-[#54b5ff]
                                     bg-[#e6f4ff] dark:bg-[#133c4d] text-[#1e4b6d] dark:text-[#8bd4ff]">
                            {{ $tag->{'name_' . $lang} }}
                        </span>
                    @endforeach
                </div>
            @endif

            <!-- Answers -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach ($question->answers as $answer)
                    <div class="flex items-center gap-2 p-2 rounded-lg
                        {{ $answer->isCorrect ? 'bg-green-100 dark:bg-green-900/30' : 'bg-slate-50 dark:bg-[#2a2a2a]' }}">
                        <span class="text-slate-800 dark:text-slate-100 text-sm">
                            {!! '$' . $answer->{'answer_' . app()->getLocale()} . '$' !!}
                        </span>
                        @if($answer->isCorrect)
                            <i class="fas fa-check text-green-600"></i>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Answered Correctly and Time -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-sm text-slate-700">
            <p>
                <strong>{{ __('history.questions-answered') }}:</strong>
                @if ($question->pivot->isCorrect)
                    <span class="text-green-600 dark:text-green-400">{{ __('history.questions-correct') }}</span>
                @else
                    <span class="text-red-600 dark:text-red-400">{{ __('history.questions-incorrect') }}</span>
                @endif
            </p>
            |
            <p>
                {{ __('history.question-time') }}
                <strong>{{ $question->pivot->time }}</strong> {{ __('history.seconds') }}
            </p>
        </div>
        </div>
    @endforeach
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
