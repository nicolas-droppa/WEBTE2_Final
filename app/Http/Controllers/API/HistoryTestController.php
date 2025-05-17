<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HistoryTest;
use App\Models\Test;
use App\Models\Answer;
use Illuminate\Http\Request;

class HistoryTestController extends Controller
{
    // List all attempts for the authenticated user
    public function index()
    {
        $list = HistoryTest::with('test')
                 ->where('user_id', auth()->id())
                 ->get();

        return response()->json(['history_tests' => $list]);
    }

    // Create a new attempt (score starts at 0)
    public function store(Request $request)
    {
        $data = $request->validate([
            'test_id' => 'required|integer|exists:tests,id',
            'city'    => 'nullable|string|max:255',
            'state'   => 'nullable|string|max:255',
        ]);

        // 1) Create the history‐test attempt
        $attempt = HistoryTest::create([
            'user_id' => auth()->id(),
            'test_id' => $data['test_id'],
            'score'   => 0,
            'city'    => $data['city']  ?? null,
            'state'   => $data['state'] ?? null,
        ]);

        // 2) Auto-populate the per-question pivot records
        $originalTest = Test::with('questions')->findOrFail($data['test_id']);
        $questionIds = $originalTest->questions->pluck('id')->toArray();

        // Build an array of pivot‐attributes for each question
        $attachData = [];
        foreach ($questionIds as $qid) {
            $attachData[$qid] = [
                'answer_id'      => null,
                'written_answer' => null,
                'time'           => null,
            ];
        }

        // Attach them in one go
        $attempt->questions()->attach($attachData);

        // 3) Return the fully seeded attempt (including its questions via the pivot)
        $attempt->load(['questions']);  
        return response()->json($attempt, 201);
    }

    // Show one attempt with its question‐records
    public function show(HistoryTest $history_test)
    {
        // Get the history-test’s own attributes
        $data = $history_test->toArray();

        // Overwrite or add a `question_ids` key with just the IDs
        $data['question_ids'] = $history_test
            ->questions()             // the belongsToMany relation
            ->pluck('questions.id')   // grab only the question IDs
            ->toArray();

        return response()->json($data);
    }

    // Update score or location on an attempt
    public function update(Request $request, HistoryTest $history_test)
    {
        $data = $request->validate([
            'score'   => 'required|integer|min:0',
            'city'    => 'sometimes|string|max:255',
            'state'   => 'sometimes|string|max:255',
        ]);

        $history_test->update($data);
        return response()->json($history_test);
    }

    // Delete an attempt and all its question‐records
    public function destroy(HistoryTest $history_test)
    {
        $history_test->questions()->detach();      // remove pivot rows
        $history_test->delete();
        return response()->json(['message'=>'Attempt deleted.']);
    }

    public function evaluate(HistoryTest $history_test)
    {
        // 1. Load all pivot records
        $records = $history_test
            ->questions()
            ->withPivot('answer_id')
            ->get();

        $total    = $records->count();
        $correct  = 0;

        foreach ($records as $question) {
            $userAnswerId = $question->pivot->answer_id;

            // 2. Find the “correct” answer for this question
            $correctAnswerId = Answer::where('question_id', $question->id)
                                     ->where('isCorrect', 1)
                                     ->value('id');

            // 3. Compare (if user never answered, $userAnswerId will be null)
            if ($userAnswerId !== null && $userAnswerId == $correctAnswerId) {
                $correct++;
            }
        }

        // 4. Update the history_test score
        $history_test->update(['score' => $correct]);

        // 5. Return summary
        return response()->json([
            'total_questions' => $total,
            'correct_answers' => $correct,
            'score'           => $correct,
        ], 200);
    }
}

