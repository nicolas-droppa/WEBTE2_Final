@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-[#54b5ff] dark:text-[#54b5ff]">Otázky</h1>
        <a href="{{ route('questions.create') }}"
            class="bg-[#54b5ff] text-white px-4 py-2 rounded hover:bg-[#3ca5ec] transition shadow">
            + Vytvoriť otázku
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('questions.index') }}"
        class="mb-8 bg-white dark:bg-[#1c1c1e] p-6 rounded-xl shadow-md border border-slate-200 dark:border-[#141414]">
        <div class="grid gap-6 md:grid-cols-2">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Hľadať otázky</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class="w-full border border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-md px-3 py-2 shadow-sm focus:ring-[#54b5ff] focus:border-[#54b5ff]">
            </div>

            <!-- Tags -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Filtrovať podľa štítkov</label>
                <div class="flex flex-wrap gap-3">
                    @foreach ($allTags as $tag)
                    <label
                        class="inline-flex items-center space-x-2 bg-slate-100 dark:bg-slate-700 px-3 py-1 rounded-full border border-slate-300 dark:border-slate-600">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            {{ collect(request('tags'))->contains($tag->id) ? 'checked' : '' }}
                            class="form-checkbox text-[#54b5ff] focus:ring-[#54b5ff] rounded">
                        <span class="text-sm text-slate-800 dark:text-white">{{ $tag->name_sk }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit"
                class="inline-block bg-[#54b5ff] text-white px-6 py-2 rounded hover:bg-[#3ca5ec] transition shadow">
                Použiť filtre
            </button>
        </div>
    </form>

    <!-- Questions -->
    @foreach ($questions as $question)
    <div class="bg-white dark:bg-[#1c1c1e] shadow-md rounded-xl p-6 mb-6 border border-slate-200 dark:border-[#141414] space-y-4">
        <div>
            <h2 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Zadanie:</h2>

            <p class="text-sm text-slate-600 dark:text-slate-300 italic">
                SK<br>{!! '$' . $question->assignment_sk . '$' !!}
            </p>

            <br>

            <p class="text-sm text-slate-600 dark:text-slate-300 italic">
                EN<br>{!! '$' . $question->assignment_en . '$' !!}
            </p>
        </div>


        <div>
            <h3 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Štítky:</h3>
            @if ($question->tags->isNotEmpty())
            <ul class="flex flex-wrap gap-2">
                @foreach ($question->tags as $tag)
                <li
                    class="bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-white text-xs font-medium px-3 py-1 rounded-full border border-slate-300 dark:border-slate-500">
                    {{ $tag->name_sk }}
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-sm text-gray-500 dark:text-slate-400 italic">Žiadne štítky</p>
            @endif
        </div>

        <div>
            <h3 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Odpovede:</h3>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($question->answers as $answer)
                <li class="flex items-center gap-2 text-slate-800 dark:text-slate-100">
                    <span>{!! '$' . $answer->answer . '$' !!}</span>
                    @if($answer->isCorrect)
                    <span class="text-green-600 font-semibold">Správna</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>

        <div class="flex items-center gap-3 pt-3 border-t border-slate-200 dark:border-[#141414]">
            <a href="{{ route('questions.edit', $question) }}"
                class="text-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                Upraviť
            </a>
            <form method="POST" action="{{ route('questions.destroy', $question) }}"
                onsubmit="return confirm('Naozaj chcete odstrániť túto otázku?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-sm px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                    Odstrániť
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/katex.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/contrib/auto-render.min.js" onload="renderMathInElement(document.body, {
        delimiters: [
            {left: '$$', right: '$$', display: true},
            {left: '$', right: '$', display: false}
        ]
    });"></script>
@endsection