<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HistoryTest;
use Illuminate\Http\Request;

class HistoryTestQuestionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user-tests/{user_test}/questions",
     *     summary="List all question-records for one test attempt",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user_test",
     *         in="path",
     *         required=true,
     *         description="ID of the user test attempt",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of questions and their pivot data",
     *         @OA\JsonContent(
     *             @OA\Property(property="questions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="question", type="object"),
     *                     @OA\Property(property="pivot", type="object")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(HistoryTest $history_test)
    {
        $records = $history_test->questions()
            ->withPivot(['answer_id','written_answer','time'])
            ->with('answers')
            ->get()
            ->map(fn($q) => [
                'question' => $q,
                'pivot'    => $q->pivot,
            ]);

        return response()->json(['questions' => $records]);
    }

    /**
     * @OA\Post(
     *     path="/api/user-tests/{user_test}/questions",
     *     summary="Record an answer/time for one question in a test attempt",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user_test",
     *         in="path",
     *         required=true,
     *         description="ID of the user test attempt",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"question_id", "time"},
     *             @OA\Property(property="question_id", type="integer", example=2),
     *             @OA\Property(property="answer_id", type="integer", nullable=true, example=5),
     *             @OA\Property(property="written_answer", type="string", nullable=true, example="My written answer"),
     *             @OA\Property(property="time", type="number", example=12.3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Question record created",
     *         @OA\JsonContent(
     *             @OA\Property(property="question", type="object"),
     *             @OA\Property(property="pivot", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request, HistoryTest $history_test)
    {
        $data = $request->validate([
            'question_id'    => 'required|exists:questions,id',
            'answer_id'      => 'nullable|exists:answers,id',
            'written_answer' => 'nullable|string|max:255',
            'time'           => 'required|numeric|min:0',
        ]);

        $history_test->questions()
            ->attach($data['question_id'], [
                'answer_id'      => $data['answer_id'] ?? null,
                'written_answer' => $data['written_answer'] ?? null,
                'time'           => $data['time'],
            ]);

        $new = $history_test->questions()
            ->where('question_id',$data['question_id'])
            ->withPivot(['answer_id','written_answer','time'])
            ->first();

        return response()->json([
            'question' => $new,
            'pivot'    => $new->pivot
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/user-tests/{user_test}/questions/{question_id}",
     *     summary="Show one question-record in a test attempt",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user_test",
     *         in="path",
     *         required=true,
     *         description="ID of the user test attempt",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="question_id",
     *         in="path",
     *         required=true,
     *         description="ID of the question",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Question record found",
     *         @OA\JsonContent(
     *             @OA\Property(property="question", type="object"),
     *             @OA\Property(property="pivot", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show(HistoryTest $history_test, $question_id)
    {
        $record = $history_test->questions()
            ->where('question_id',$question_id)
            ->withPivot(['answer_id','written_answer','time'])
            ->with('answers')   
            ->firstOrFail();

        return response()->json([
            'question' => $record,
            'pivot'    => $record->pivot
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/user-tests/{user_test}/questions/{question_id}",
     *     summary="Update answer/time for one question-record",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user_test",
     *         in="path",
     *         required=true,
     *         description="ID of the user test attempt",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="question_id",
     *         in="path",
     *         required=true,
     *         description="ID of the question",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="answer_id", type="integer", nullable=true, example=6),
     *             @OA\Property(property="written_answer", type="string", nullable=true, example="Changed answer"),
     *             @OA\Property(property="time", type="number", example=15.7)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Question record updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="question", type="object"),
     *             @OA\Property(property="pivot", type="object")
     *         )
     *     )
     * )
     */
    public function update(Request $request, HistoryTest $history_test, $question_id)
    {
        $data = $request->validate([
            'answer_id'      => 'sometimes|exists:answers,id',
            'written_answer' => 'sometimes|string|max:255',
            'time'           => 'sometimes|numeric|min:0',
        ]);

        $history_test->questions()
            ->updateExistingPivot($question_id, $data);

        $updated = $history_test->questions()
            ->where('question_id',$question_id)
            ->withPivot(['answer_id','written_answer','time'])
            ->first();

        return response()->json([
            'question' => $updated,
            'pivot'    => $updated->pivot
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/user-tests/{user_test}/questions/{question_id}",
     *     summary="Remove a question-record from a test attempt",
     *     tags={"User Tests"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="user_test",
     *         in="path",
     *         required=true,
     *         description="ID of the user test attempt",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="question_id",
     *         in="path",
     *         required=true,
     *         description="ID of the question",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Record deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Record deleted.")
     *         )
     *     )
     * )
     */
    public function destroy(HistoryTest $history_test, $question_id)
    {
        $history_test->questions()->detach($question_id);
        return response()->json(['message'=>'Record deleted.']);
    }
}