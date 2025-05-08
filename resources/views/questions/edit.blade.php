@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-semibold mb-6">Edit Question</h2>

    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <strong>There were some problems with your input:</strong>
        <ul class="mt-2 list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('questions.update', $question) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Assignment (SK)</label>
            <input type="text" name="assignment_sk" value="{{ old('assignment_sk', $question->assignment_sk) }}" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Assignment (EN)</label>
            <input type="text" name="assignment_en" value="{{ old('assignment_en', $question->assignment_en) }}" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>

        <div class="flex items-center mb-6 space-x-2">
            <input type="hidden" name="isMultiChoice" value="0">
            <input type="checkbox" id="multiChoice" name="isMultiChoice" value="1" {{ old('isMultiChoice', $question->isMultiChoice) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="multiChoice" class="text-sm text-gray-700">Is Multi Choice?</label>
        </div>

        <div id="answers">
            <h3 class="text-lg font-semibold mb-2">Answers</h3>

            @foreach (old('answers', $question->answers->toArray()) as $index => $answer)
            <div class="answer mb-4 border border-gray-200 p-4 rounded-md bg-gray-50 relative">
                <input type="text" name="answers[{{ $index }}][answer]" value="{{ $answer['answer'] }}" placeholder="Answer text" class="w-full border border-gray-300 p-2 rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <div class="flex items-center space-x-2">
                    <input type="hidden" name="answers[{{ $index }}][isCorrect]" value="0">
                    <input id="answers[{{ $index }}][isCorrect]" type="checkbox" name="answers[{{ $index }}][isCorrect]" value="1" {{ $answer['isCorrect'] ? 'checked' : '' }} class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <label for="answers[{{ $index }}][isCorrect]" class="text-sm text-gray-700">Is Correct?</label>
                </div>
                <button type="button" class="remove-answer absolute top-2 right-2 text-sm text-red-500 hover:text-red-700">Delete</button>
            </div>
            @endforeach
        </div>

        <button type="button" id="add-answer" class="px-4 py-2 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 transition mb-6">
            + Add Another Answer
        </button>

        <div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                Update Question
            </button>
        </div>
    </form>
</div>

<script>
    let answerCount = {{count(old('answers', $question->answers))}};

    document.getElementById('add-answer').addEventListener('click', () => {
        const container = document.createElement('div');
        container.classList.add('answer', 'mb-4', 'border', 'border-gray-200', 'p-4', 'rounded-md', 'bg-gray-50', 'relative');

        container.innerHTML = `
            <input type="text" name="answers[${answerCount}][answer]" placeholder="Answer text" class="w-full border border-gray-300 p-2 rounded mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div class="flex items-center space-x-2">
                <input type="hidden" name="answers[${answerCount}][isCorrect]" value="0">
                <input id="answers[${answerCount}][isCorrect]" type="checkbox" name="answers[${answerCount}][isCorrect]" value="1" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label for="answers[${answerCount}][isCorrect]" class="text-sm text-gray-700">Is Correct?</label>
            </div>
            <button type="button" class="remove-answer absolute top-2 right-2 text-sm text-red-500 hover:text-red-700">
                Delete
            </button>
        `;

        document.getElementById('answers').appendChild(container);
        answerCount++;
    });

    document.getElementById('answers').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-answer')) {
            e.target.closest('.answer').remove();
        }
    });
</script>
@endsection