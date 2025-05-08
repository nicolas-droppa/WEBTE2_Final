@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Questions</h1>
        <a href="{{ route('questions.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Create Question
        </a>
    </div>

    @foreach ($questions as $question)
    <div class="bg-white shadow-sm rounded-lg p-6 mb-6 border border-gray-200">
        <div class="mb-4">
            <h2 class="text-lg font-semibold text-slate-900">
                {{ $question->assignment_en }}
            </h2>
            <p class="text-sm text-slate-600 italic">{{ $question->assignment_sk }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-sm font-medium text-slate-700 mb-2">Answers:</h3>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($question->answers as $answer)
                <li class="flex items-center gap-2">
                    <span>{{ $answer->answer }}</span>
                    @if($answer->isCorrect)
                    <span class="text-green-600 font-semibold">Correct</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('questions.edit', $question) }}"
                class="text-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                Edit
            </a>

            <form method="POST" action="{{ route('questions.destroy', $question) }}"
                onsubmit="return confirm('Are you sure you want to delete this question?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-sm px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection