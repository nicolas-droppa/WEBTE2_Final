<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use App\Models\HistoryTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestTakingController extends Controller
{
    public function start(Test $test)
    {
        // Create a new history test entry
        $historyTest = HistoryTest::create([
            'user_id' => Auth::id(),
            'test_id' => $test->id,
            'city'    => 'unknown', // Customize based on your input
            'state'   => 'unknown',       // Customize based on your input
        ]);

        // Randomize the questions
        $questions = $test->questions()->inRandomOrder()->pluck('id')->toArray();

        // Store session data to track progress
        session([
            'current_test' => $test->id,
            'history_test_id' => $historyTest->id,
            'question_ids' => $questions,
            'current_index' => 0,
            'start_time' => now(),
        ]);

        return redirect()->route('test.question');
    }

    public function showQuestion()
    {
        $questionIds = session('question_ids');
        $index = session('current_index');
        $historyTestId = session('history_test_id');

        if (! $questionIds || ! isset($questionIds[$index])) {
            return redirect()->route('test.result');
        }

        // Eager load the 'answers' relationship
        $question = Question::with('answers')->findOrFail($questionIds[$index]);

        return view('test.question', [
            'question' => $question,
            'start' => now()->timestamp,
            'history_test_id' => $historyTestId,
        ]);
    }

    public function submitAnswer(Request $request)
    {
        $request->validate([
            'question_id'     => 'required|exists:questions,id',
            'start_timestamp' => 'required|integer',
            'history_test_id' => 'required|exists:history_tests,id',
        ]);

        $question = Question::findOrFail($request->question_id);
        $historyTestId = $request->history_test_id;
        $timeTaken = now()->timestamp - $request->start_timestamp;

        $data = [
            'history_test_id' => $historyTestId,
            'question_id'     => $question->id,
            'time'            => $timeTaken,
        ];

        if ($question->isMultiChoice) {
            $request->validate([
                'answer_id' => 'required|exists:answers,id',
            ]);
            $data['answer_id'] = $request->answer_id;
        } else {
            $request->validate([
                'written_answer' => 'required|string',
            ]);
            $data['written_answer'] = $request->written_answer;
        }

        DB::table('history_test_question')->updateOrInsert(
            [
                'history_test_id' => $historyTestId,
                'question_id'     => $question->id,
            ],
            $data
        );

        $index = session('current_index', 0);
        $questionIds = session('question_ids');
        $index++;
        dd($index);

        session(['current_index' => $index]);

        if ($index < count($questionIds)) {
            return redirect()->route('test.question');
        }

        return redirect()->route('test.result');
    }



    public function result()
    {
        $historyTestId = session('history_test_id');
        $history = HistoryTest::with(['test', 'questions.answers', 'questions.correctAnswer'])->findOrFail($historyTestId);

        $totalTime = 0;
        $correct = 0;
        $total = count($history->questions);

        foreach ($history->questions as $question) {
            $pivot = $question->pivot;
            $totalTime += $pivot->time ?? 0;

            if ($question->type === 'written') {
                // Manual scoring or keyword match here
                continue;
            }

            if ($pivot->answer_id == $question->correctAnswer?->id) {
                $correct++;
            }
        }

        $averageTime = $total > 0 ? round($totalTime / $total, 2) : 0;

        // Save score to history_tests
        $history->update(['score' => $correct]);

        // Clear session
        session()->forget(['current_test', 'history_test_id', 'question_ids', 'current_index', 'start_time']);

        return view('test.result', [
            'history' => $history,
            'score' => $correct,
            'averageTime' => $averageTime,
            'totalTime' => $totalTime,
        ]);
    }
}
