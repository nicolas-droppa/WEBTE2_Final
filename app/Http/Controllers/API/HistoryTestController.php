<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HistoryTest;
use App\Models\Test;
use App\Models\Answer;
use Illuminate\Http\Request;

class HistoryTestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user-tests",
     *     summary="List all attempts for the authenticated user",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of test attempts",
     *         @OA\JsonContent(
     *             @OA\Property(property="history_tests", type="array",
     *                 @OA\Items(ref="#/components/schemas/HistoryTest")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function index()
    {
        $list = HistoryTest::with('test')
                 ->where('user_id', auth()->id())
                 ->get();

        return response()->json(['history_tests' => $list]);
    }

    /**
     * @OA\Post(
     *     path="/api/user-tests",
     *     summary="Create a new test attempt",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"test_id"},
     *             @OA\Property(property="test_id", type="integer", example=1),
     *             @OA\Property(property="city", type="string", example="Bratislava"),
     *             @OA\Property(property="state", type="string", example="Slovakia")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Attempt created",
     *         @OA\JsonContent(ref="#/components/schemas/HistoryTest")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'test_id' => 'required|integer|exists:tests,id',
            'city'    => 'nullable|string|max:255',
            'state'   => 'nullable|string|max:255',
        ]);
        $attempt = HistoryTest::create([
            'user_id' => auth()->id(),
            'test_id' => $data['test_id'],
            'score'   => 0,
            'city'    => $data['city']  ?? null,
            'state'   => $data['state'] ?? null,
        ]);
        $originalTest = Test::with('questions')->findOrFail($data['test_id']);
        $questionIds = $originalTest->questions->pluck('id')->toArray();
        $attachData = [];
        foreach ($questionIds as $qid) {
            $attachData[$qid] = [
                'answer_id'      => null,
                'written_answer' => null,
                'time'           => null,
            ];
        }
        $attempt->questions()->attach($attachData);
        $attempt->load(['questions']);  
        return response()->json($attempt, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/user-tests/{user_test}",
     *     summary="Show one test attempt with its question records",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user_test",
     *         in="path",
     *         required=true,
     *         description="ID of the user test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User test attempt with question IDs",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="test_id", type="integer"),
     *             @OA\Property(property="score", type="integer"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="state", type="string"),
     *             @OA\Property(property="question_ids", type="array", @OA\Items(type="integer"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show(HistoryTest $history_test)
    {
        $data = $history_test->toArray();
        $data['question_ids'] = $history_test
            ->questions()
            ->pluck('questions.id')
            ->toArray();
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/api/user-tests/{user_test}",
     *     summary="Update score or location on a test attempt",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user_test",
     *         in="path",
     *         required=true,
     *         description="ID of the user test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"score"},
     *             @OA\Property(property="score", type="integer", example=5),
     *             @OA\Property(property="city", type="string", example="Bratislava"),
     *             @OA\Property(property="state", type="string", example="Slovakia")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User test updated",
     *         @OA\JsonContent(ref="#/components/schemas/HistoryTest")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/user-tests/{user_test}",
     *     summary="Delete a test attempt and its question records",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user_test",
     *         in="path",
     *         required=true,
     *         description="ID of the user test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attempt deleted message",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Attempt deleted.")
     *         )
     *     )
     * )
     */
    public function destroy(HistoryTest $history_test)
    {
        $history_test->questions()->detach();
        $history_test->delete();
        return response()->json(['message'=>'Attempt deleted.']);
    }

    /**
     * @OA\Post(
     *     path="/api/user-tests/{user_test}/evaluate",
     *     summary="Evaluate a user test attempt and update score",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user_test",
     *         in="path",
     *         required=true,
     *         description="ID of the user test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evaluation summary",
     *         @OA\JsonContent(
     *             @OA\Property(property="total_questions", type="integer", example=10),
     *             @OA\Property(property="correct_answers", type="integer", example=8),
     *             @OA\Property(property="score", type="integer", example=8)
     *         )
     *     )
     * )
     */
    public function evaluate(HistoryTest $history_test)
    {
        $records = $history_test
            ->questions()
            ->withPivot('answer_id')
            ->get();
        $total    = $records->count();
        $correct  = 0;
        foreach ($records as $question) {
            $userAnswerId = $question->pivot->answer_id;
            $correctAnswerId = Answer::where('question_id', $question->id)
                                     ->where('isCorrect', 1)
                                     ->value('id');
            if ($userAnswerId !== null && $userAnswerId == $correctAnswerId) {
                $correct++;
            }
        }
        $history_test->update(['score' => $correct]);
        return response()->json([
            'total_questions' => $total,
            'correct_answers' => $correct,
            'score'           => $correct,
        ], 200);
    }
}