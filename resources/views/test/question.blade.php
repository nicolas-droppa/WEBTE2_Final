@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('test.answer') }}">
    @csrf

    <h2 class="text-xl font-semibold mb-4">{{ $question->assignment_sk }}</h2>

    @foreach($question->answers as $answer)
    <div class="mb-2">
        @if($question->isMultiChoice)
        {{-- Multi-choice: checkboxes --}}
        <input type="radio" name="answer_id" value="{{ $answer->id }}" id="answer_{{ $answer->id }}">
        @else(!$question->type)
        <div class="mb-4">
            <textarea name="written_answer" class="w-full border rounded p-2" rows="4" placeholder="Write your answer..."></textarea>
        </div>
        @endif
        <label for="answer_{{ $answer->id }}">{{ $answer->answer_sk }}</label>
    </div>
    @endforeach


    <input type="hidden" name="question_id" value="{{ $question->id }}">
    <input type="hidden" name="start_timestamp" value="{{ $start }}">

    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
        Submit
    </button>
</form>
@endsection