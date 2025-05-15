@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-6 mt-16 mb-20">
    {{-- Validation Errors --}}
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-300 dark:border-red-500 text-red-600 dark:text-red-400 rounded-lg">
        <strong class="block text-sm font-semibold mb-2">{{ __('general.input_errors') }}</strong>
        <ul class="list-disc pl-5 text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <h1 class="text-4xl font-bold text-slate-800 dark:text-gray-100">
            <i class="fas fa-plus mr-2 text-[#54b5ff]"></i>
            {{ __('tests.create_title') }}
        </h1>
        <a href="{{ route('admin.tests.index') }}"
           class="bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-white px-4 py-2 rounded hover:bg-slate-300 dark:hover:bg-slate-600 transition shadow flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> {{ __('tests.back_to_list') }}
        </a>
    </div>

    {{-- Create Test Form --}}
    <form action="{{ route('admin.tests.store') }}" method="POST" id="test-form"
          class="bg-white dark:bg-[#1c1c1e] p-8 rounded-xl shadow-md border border-slate-200 dark:border-[#141414] space-y-6">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                {{ __('tests.title_label') }}
            </label>
            <input
                type="text"
                name="title"
                id="title"
                value="{{ old('title') }}"
                required
                class="w-full border border-slate-300 dark:border-slate-600 dark:bg-[#2a2a2a] dark:text-white rounded-md px-3 py-2 shadow-sm focus:ring-[#54b5ff] focus:border-[#54b5ff]"
            >
            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Questions list with modern badge style KaTeX --}}
        <div id="questions_section">
            <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-100 mb-2">
                {{ __('tests.select_questions') }}
            </h3>
            <div class="space-y-4">
                @foreach($questions as $question)
                <div>
                    <input type="checkbox" id="q_{{ $question->id }}" name="questions[]" value="{{ $question->id }}" class="peer sr-only" />
                    <label for="q_{{ $question->id }}" class="flex items-center p-4 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-[#2a2a2a] cursor-pointer hover:border-[#54b5ff] peer-checked:border-[#54b5ff] peer-checked:bg-[#54b5ff]/10 transition">
                        <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center text-[#54b5ff] peer-checked:bg-[#54b5ff] peer-checked:text-white transition">
                            {{ $loop->iteration }}
                        </span>
                        <div class="w-px h-6 bg-slate-300 dark:bg-slate-600 mx-3"></div>
                        <div class="question-text flex-1 text-sm text-slate-800 dark:text-slate-200 break-words">
                            {!! $question->{'assignment_' . app()->getLocale()} !!}
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
            @error('questions')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <div>
            <button type="submit"
                    class="w-full bg-[#54b5ff] hover:bg-[#3ca5ec] text-white font-semibold px-6 py-2 rounded transition shadow flex items-center justify-center gap-2">
                <i class="fas fa-save"></i> {{ __('tests.save_button') }}
            </button>
        </div>
    </form>

    {{-- Scroll Toggle Button --}}
    <button id="scroll-toggle"
            class="fixed bottom-6 right-6 bg-[#54b5ff] hover:bg-[#3ca5ec] text-white p-3 rounded-full shadow-lg transition">
        <i id="scroll-icon" class="fas fa-arrow-down"></i>
    </button>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/katex.min.css">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/katex.min.js"></script>
<script>
// Render KaTeX
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.question-text').forEach(el => {
        try {
            el.innerHTML = katex.renderToString(el.textContent, { throwOnError: false, displayMode: false });
        } catch {
            el.innerHTML = '<span class="text-red-500">Invalid LaTeX</span>';
        }
    });
    // Scroll toggle logic
    const btn = document.getElementById('scroll-toggle');
    const icon = document.getElementById('scroll-icon');
    let atBottom = false;
    btn.addEventListener('click', () => {
        if (!atBottom) {
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
            icon.classList.replace('fa-arrow-down', 'fa-arrow-up');
        } else {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            icon.classList.replace('fa-arrow-up', 'fa-arrow-down');
        }
        atBottom = !atBottom;
    });
});
</script>
@endsection