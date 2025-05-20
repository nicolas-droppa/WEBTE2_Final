<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class TestQuestionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tests/{test}/questions",
     *     summary="List all questions for a test, with optional search and tags filter",
     *     tags={"Tests"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="test",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Search in assignment_en or assignment_sk",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tags[]",
     *         in="query",
     *         required=false,
     *         description="Filter by tag IDs (array)",
     *         @OA\Schema(type="array", @OA\Items(type="integer"))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of questions for the test",
     *         @OA\JsonContent(
     *             @OA\Property(property="questions", type="array", @OA\Items(ref="#/components/schemas/Question"))
     *         )
     *     )
     * )
     */
    public function index(Test $test, Request $request)
    {
        $query = $test->questions()->with(['answers','tags']);

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('assignment_en','like',"%{$search}%")
                  ->orWhere('assignment_sk','like',"%{$search}%");
            });
        }

        if ($tagIds = $request->input('tags')) {
            foreach ($tagIds as $tagId) {
                $query->whereHas('tags', fn($q) => $q->where('tags.id',$tagId));
            }
        }

        return response()->json([
            'questions' => $query->get(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/tests/{test}/questions/{question}",
     *     summary="Get one question (with answers and tags) for this test",
     *     tags={"Tests"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="test",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         required=true,
     *         description="ID of the question",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The question resource",
     *         @OA\JsonContent(ref="#/components/schemas/Question")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show(Test $test, Question $question)
    {
        $test->questions()->findOrFail($question->id);
        return response()->json(
            $question->load(['answers','tags'])
        );
    }

    /**
     * @OA\Post(
     *     path="/api/tests/{test}/questions",
     *     summary="Create and attach a new question to the test",
     *     tags={"Tests"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="test",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"assignment_sk","assignment_en","isMultiChoice","answers","tag_ids"},
     *             @OA\Property(property="assignment_sk", type="string", example="Koľko je 2+2?"),
     *             @OA\Property(property="assignment_en", type="string", example="What is 2+2?"),
     *             @OA\Property(property="isMultiChoice", type="boolean", example=false),
     *             @OA\Property(
     *                 property="answers",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="answer_sk", type="string", example="Štyri"),
     *                     @OA\Property(property="answer_en", type="string", example="Four"),
     *                     @OA\Property(property="isCorrect", type="boolean", example=true)
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="tag_ids",
     *                 type="array",
     *                 @OA\Items(type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Question created and attached",
     *         @OA\JsonContent(ref="#/components/schemas/Question")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request, Test $test)
    {
        $data = $request->validate([
            'assignment_sk'      => 'required|string|max:1028',
            'assignment_en'      => 'required|string|max:1028',
            'isMultiChoice'      => 'required|boolean',
            'answers'            => 'required|array|min:1',
            'answers.*.answer_sk'=> 'required|string|max:255',
            'answers.*.answer_en'=> 'required|string|max:255',
            'answers.*.isCorrect'=> 'required|boolean',
            'tag_ids'            => 'required|array',
            'tag_ids.*'          => 'integer|exists:tags,id',
        ]);

        $question = Question::create([
            'assignment_sk' => $data['assignment_sk'],
            'assignment_en' => $data['assignment_en'],
            'isMultiChoice' => $data['isMultiChoice'],
        ]);

        foreach ($data['answers'] as $ans) {
            $question->answers()->create($ans);
        }

        if (!empty($data['tag_ids'])) {
            $question->tags()->sync($data['tag_ids']);
        }

        $test->questions()->attach($question->id);

        return response()->json(
            $question->load(['answers','tags']),
            201
        );
    }

    /**
     * @OA\Put(
     *     path="/api/tests/{test}/questions/{question}",
     *     summary="Update a question attached to this test",
     *     tags={"Tests"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="test",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         required=true,
     *         description="ID of the question",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"assignment_sk","assignment_en","isMultiChoice","answers","tag_ids"},
     *             @OA\Property(property="assignment_sk", type="string", example="Koľko je 2+2?"),
     *             @OA\Property(property="assignment_en", type="string", example="What is 2+2?"),
     *             @OA\Property(property="isMultiChoice", type="boolean", example=false),
     *             @OA\Property(
     *                 property="answers",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="answer_sk", type="string", example="Štyri"),
     *                     @OA\Property(property="answer_en", type="string", example="Four"),
     *                     @OA\Property(property="isCorrect", type="boolean", example=true)
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="tag_ids",
     *                 type="array",
     *                 @OA\Items(type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Question updated",
     *         @OA\JsonContent(ref="#/components/schemas/Question")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, Test $test, Question $question)
    {
        $test->questions()->findOrFail($question->id);

        $data = $request->validate([
            'assignment_sk'      => 'required|string|max:1028',
            'assignment_en'      => 'required|string|max:1028',
            'isMultiChoice'      => 'required|boolean',
            'answers'            => 'required|array|min:1',
            'answers.*.answer_sk'=> 'required_with:answers|string|max:255',
            'answers.*.answer_en'=> 'required_with:answers|string|max:255',
            'answers.*.isCorrect'=> 'required_with:answers|boolean',
            'tag_ids'            => 'required|array|min:1',
            'tag_ids.*'          => 'integer|exists:tags,id',
        ]);

        $question->update([
            'assignment_sk' => $data['assignment_sk'],
            'assignment_en' => $data['assignment_en'],
            'isMultiChoice' => $data['isMultiChoice'],
        ]);

        if (array_key_exists('answers',$data)) {
            $question->answers()->delete();
            foreach ($data['answers'] as $ans) {
                $question->answers()->create($ans);
            }
        }

        if (array_key_exists('tag_ids',$data)) {
            $question->tags()->sync($data['tag_ids']);
        }

        return response()->json(
            $question->load(['answers','tags'])
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/tests/{test}/questions/{question}",
     *     summary="Detach and delete a question from a test",
     *     tags={"Tests"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="test",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         required=true,
     *         description="ID of the question",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Question detached and deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Question 1 removed and deleted.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function destroy(Test $test, Question $question)
    {
        $test->questions()->findOrFail($question->id);
        $test->questions()->detach($question->id);
        $question->answers()->delete();
        $question->tags()->detach();
        $question->delete();

        return response()->json([
            'message' => "Question {$question->id} removed and deleted."
        ], 200);
    }
}