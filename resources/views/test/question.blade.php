@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('test.answer') }}"
    class="max-w-3xl mx-auto bg-white dark:bg-[#1c1c1e] p-6 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 space-y-6 mt-10">
    @csrf

    @php
        $assignment = $question->{'assignment_' . app()->getLocale()};
        $isMulti = $question->isMultiChoice;
    @endphp

    <div class="overflow-x-auto">
        <h2 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 leading-relaxed min-w-fit">
            {!! '$' . $question->{'assignment_' . app()->getLocale()} . '$' !!}
        </h2>
    </div>

    @foreach($question->answers as $answer)
        @if($isMulti)
        <label for="answer_{{ $answer->id }}"
            class="flex items-center gap-3 p-4 rounded-md border border-slate-300 dark:border-[#292929] bg-slate-50 dark:bg-[#2a2a2a] transition hover:border-[#54b5ff] dark:hover:border-[#54b5ff] cursor-pointer shadow-sm">
            <input type="radio" name="answer_id" value="{{ $answer->id }}" id="answer_{{ $answer->id }}"
                class="w-5 h-5 text-[#54b5ff] bg-white dark:bg-[#1c1c1e] border-gray-300 dark:border-[#444] rounded focus:ring-[#54b5ff] dark:focus:ring-[#78cfff]">
            <span class="text-slate-800 dark:text-slate-100 text-sm">{!! '$' . $answer->{'answer_' . app()->getLocale()} . '$' !!}</span>
        </label>
        @endif
    @endforeach

    @if(!$isMulti)
    <div>
        <label for="written_answer" class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ __('tests.your_answer') }}
        </label>
        <textarea name="written_answer" id="written_answer"
            class="w-full rounded-md border border-slate-300 dark:border-slate-600 dark:bg-[#2a2a2a] text-slate-800 dark:text-white p-3 focus:ring-[#54b5ff] focus:border-[#54b5ff]"
            rows="5"
            placeholder="{{ __('test.write_here') }}"></textarea>
    </div>
    @endif

    <input type="hidden" name="question_id" value="{{ $question->id }}">
    <input type="hidden" name="start_timestamp" value="{{ $start }}">

    <div class="pt-4">
        <button type="submit"
            class="w-full inline-flex items-center justify-center px-6 py-2 bg-[#54b5ff] text-white font-semibold rounded-md hover:bg-[#3ca5ec] transition shadow">
            <i class="fas fa-paper-plane mr-2"></i> {{ __('tests.submit') }}
        </button>
    </div>
</form>
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
