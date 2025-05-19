@extends('layouts.app')

@section('content')
<h2>Test Results: {{ $history->test->title }}</h2>
<p>Score: {{ $score }}/{{ $history->questions->count() }}</p>
<p>Total Time: {{ $totalTime }} seconds</p>
<p>Average Time per Question: {{ $averageTime }} seconds</p>

<ul>
    @foreach($history->questions as $question)
    <li>
        <strong>{{ $question->text }}</strong><br>
        Your Answer:
        @if($question->pivot->answer_id)
        {{ $question->answers->firstWhere('id', $question->pivot->answer_id)?->text }}
        @else
        {{ $question->pivot->written_answer ?? '-' }}
        @endif<br>
        Correct Answer:
        {{ $question->correctAnswer?->text ?? 'N/A' }}<br>
        Time Spent: {{ $question->pivot->time }} seconds
    </li>
    @endforeach
</ul>
@endsection