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
            'city'    => 'unknown',
            'state'   => 'unknown',
        ]);

        // Randomize and store questions
        $questions = $test->questions()->inRandomOrder()->pluck('id')->toArray();

        // Create empty rows for each question in pivot table
        foreach ($questions as $questionId) {
            DB::table('history_test_question')->insert([
                'history_test_id' => $historyTest->id,
                'question_id'     => $questionId,
                'answer_id' => null,
            ]);
        }

        // Store session data
        session([
            'current_test'     => $test->id,
            'history_test_id'  => $historyTest->id,
            'question_ids'     => $questions,
            'current_index'    => 0,
            'start_time'       => now(),
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

        $question = Question::with('answers')->findOrFail($questionIds[$index]);

        return view('test.question', [
            'question'        => $question,
            'start'           => now()->timestamp,
            'history_test_id' => $historyTestId,
        ]);
    }

    public function submitAnswer(Request $request)
    {
        $request->validate([
            'question_id'     => 'required|exists:questions,id',
            'start_timestamp' => 'required|integer',
        ]);
        $question = Question::findOrFail($request->question_id);
        $historyTestId = session('history_test_id');
        $timeTaken = now()->timestamp - $request->start_timestamp;

        $data = [
            'time' => $timeTaken,
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


        // Update existing pivot record
        DB::table('history_test_question')
            ->where('history_test_id', $historyTestId)
            ->where('question_id', $question->id)
            ->update(array_merge($data));

        // Move to next question
        $index = session('current_index', 0) + 1;
        session(['current_index' => $index]);

        $questionIds = session('question_ids');
        if ($index < count($questionIds)) {
            return redirect()->route('test.question');
        }

        return redirect()->route('test.result');
    }

    public function result()
    {
        $historyTestId = session('history_test_id');
        $history = HistoryTest::with(['test', 'questions.answers'])->findOrFail($historyTestId);


        $totalTime = 0;
        $correct = 0;
        $total = count($history->questions);

        foreach ($history->questions as $question) {
            $pivot = $question->pivot;
            $totalTime += $pivot->time ?? 0;

            if (!$question->isMultiChoice) {
                $correctAnswer = $question->answers->firstWhere('isCorrect', true)?->text;
                $userAnswer = $pivot->written_answer;

                if ($this->isWrittenAnswerCorrect($userAnswer ?? "", $correctAnswer ?? "")) {
                    $correct++;
                }

                continue;
            }

            $correctAnswerId = $question->answers()->where('isCorrect', true)->value('id');

            if ($pivot->answer_id == $correctAnswerId) {
                $correct++;
            }
        }

        $averageTime = $total > 0 ? round($totalTime / $total, 2) : 0;

        $history->update(['score' => $correct]);

        session()->forget([
            'current_test',
            'history_test_id',
            'question_ids',
            'current_index',
            'start_time',
        ]);

        return view('test.result', [
            'history'      => $history,
            'score'        => $correct,
            'averageTime'  => $averageTime,
            'totalTime'    => $totalTime,
        ]);
    }

    private function isWrittenAnswerCorrect(string $userAnswer, string $correctAnswer): bool
    {
        $normalize = function ($input) {
            return collect(explode(',', strtolower($input)))
                ->map(function ($item) {
                    // Remove units and spaces
                    return trim(preg_replace('/[^0-9.]/', '', $item));
                })
                ->filter() // remove empty items
                ->sort()
                ->values()
                ->toArray();
        };

        $normalizedUser = $normalize($userAnswer);
        $normalizedCorrect = $normalize($correctAnswer);

        return $normalizedUser === $normalizedCorrect;
    }
}
