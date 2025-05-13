@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 mt-16 mb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <h1 class="text-4xl font-bold text-slate-800 dark:text-gray-100">
            <i class="fas fa-list-ul mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
            {{ __('questions.title') }}
        </h1>
        <a href="{{ route('questions.create') }}"
            class="bg-[#54b5ff] text-white px-4 py-2 rounded hover:bg-[#3ca5ec] transition shadow flex items-center gap-2">
            <i class="fas fa-plus"></i> {{ __('questions.create') }}
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('questions.index') }}"
        class="mb-10 bg-white dark:bg-[#1c1c1e] p-8 rounded-xl shadow-md border border-slate-200 dark:border-[#141414] space-y-6">

        <!-- Search bar -->
        <div>
            <label for="search"
                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                <i class="fas fa-search mr-1 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                {{ __('questions.search_label') }}
            </label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="w-full border border-slate-300 dark:border-slate-600 dark:bg-[#2a2a2a] dark:text-white rounded-md px-3 py-2 shadow-sm focus:ring-[#54b5ff] focus:border-[#54b5ff]">
        </div>

        <!-- Tags full-width under search -->
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                <i class="fas fa-tags mr-1 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                {{ __('questions.tags_label') }}
            </label>
            <div class="flex flex-wrap gap-3">
                @foreach ($allTags as $tag)
                @php
                $isSelected = collect(request('tags'))->contains($tag->id);
                @endphp
                <label class="cursor-pointer">
                    <input
                        type="checkbox"
                        name="tags[]"
                        value="{{ $tag->id }}"
                        class="hidden peer"
                        {{ $isSelected ? 'checked' : '' }} />
                    <span
                        class="peer-checked:bg-[#54b5ff]/10 peer-checked:text-[#54b5ff]
                                inline-flex items-center px-3 py-1 rounded-full border
                                border-[#54b5ff] text-sm font-medium
                                text-slate-800 dark:text-white transition">
                        {{ $tag->{'name_' . app()->getLocale()} }}
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="inline-block bg-[#54b5ff] text-white px-6 py-2 rounded hover:bg-[#3ca5ec] transition shadow">
                <i class="fas fa-filter mr-1"></i> {{ __('questions.filter_button') }}
            </button>
        </div>
    </form>


    <!-- Questions -->
    @php
    $lang = app()->getLocale();
    @endphp

    @foreach ($questions as $question)
    <div class="bg-white dark:bg-[#1c1c1e] shadow-md rounded-xl p-6 mb-6 border border-slate-200 dark:border-[#141414] space-y-4">

        {{-- Top row: tags left, edit/delete right --}}
        <div class="flex flex-wrap justify-between items-start gap-2">
            {{-- Tags --}}
            <ul class="flex flex-wrap gap-2">
                @foreach ($question->tags as $tag)
                <li class="text-xs font-medium px-3 py-1 rounded-xl border border-[#54b5ff]
                            bg-[#e6f4ff] dark:bg-[#133c4d] text-[#1e4b6d] dark:text-[#8bd4ff]">
                    {{ $tag->{'name_' . $lang} }}
                </li>
                @endforeach
            </ul>

            {{-- Edit / Delete buttons --}}
            <div class="flex gap-2">
                <a href="{{ route('questions.edit', $question) }}"
                    class="text-yellow-500 hover:text-yellow-600 transition text-lg" title="{{ __('questions.edit') }}">
                    <i class="fas fa-edit"></i>
                </a>
                <form method="POST" action="{{ route('questions.destroy', $question) }}"
                    onsubmit="return confirm('{{ __('questions.delete_confirm') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-red-500 hover:text-red-600 transition text-lg" title="{{ __('questions.delete') }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Assignment --}}
        <div class="pl-3 border-l-4 border-[#54b5ff]">
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-1">
                {{ __('questions.assignment_label') }}
            </p>
            <p class="text-sm text-slate-700 dark:text-slate-300 italic">
                {!! '$' . $question->{'assignment_' . $lang} . '$' !!}
            </p>
        </div>

        {{-- Answers --}}
        @if ($question->answers->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-2">
            @foreach ($question->answers as $answer)
            <div class="flex items-start gap-2 p-3 rounded-md border
                {{ $answer->isCorrect ? 'border-green-500 bg-green-100 dark:bg-green-900/30' : 'border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-[#2a2a2a]' }}">
                <span class="text-slate-800 dark:text-slate-100 text-sm">
                    {!! '$' . $answer->{'answer_' . $lang} . '$' !!}
                </span>
                @if($answer->isCorrect)
                <i class="fas fa-check text-green-600 mt-0.5 ml-auto" title="{{ __('questions.correct_answer') }}"></i>
                @endif
            </div>
            @endforeach
        </div>
        @endif
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