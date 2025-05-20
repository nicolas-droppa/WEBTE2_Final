<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/questions",
     *     summary="List questions, filterable by search string or tags",
     *     tags={"Questions"},
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
     *         description="Questions fetched",
     *         @OA\JsonContent(
     *             @OA\Property(property="questions", type="array", @OA\Items(ref="#/components/schemas/Question"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Question::with(['answers', 'tags']);

        // Apply search filter
        if ($search = $request->input('search')) {
            $query->where('assignment_en', 'like', "%$search%")
                ->orWhere('assignment_sk', 'like', "%$search%");
        }

        // Apply tag filters
        if ($tagIds = $request->input('tags')) {
            foreach ($tagIds as $tagId) {
                $query->whereHas('tags', function ($q) use ($tagId) {
                    $q->where('tags.id', $tagId);
                });
            }
        }

        $questions = $query->get();

        return response()->json([
            'questions' => $questions,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/questions/{id}",
     *     summary="Show one question with answers and tags",
     *     tags={"Questions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the question",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Question with answers and tags",
     *         @OA\JsonContent(ref="#/components/schemas/Question")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show($id)
    {
        $question = Question::with(['answers', 'tags'])->findOrFail($id);

        return response()->json($question);
    }

    /**
     * @OA\Post(
     *     path="/api/questions",
     *     summary="Create a new question with answers and tags",
     *     tags={"Questions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"assignment_sk","assignment_en","isMultiChoice","answers"},
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
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/Question")
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
            'assignment_sk'   => 'required|string|max:1028',
            'assignment_en'   => 'required|string|max:1028',
            'isMultiChoice'   => 'required|boolean',
            'answers'         => 'required|array|min:1',
            'answers.*.answer_sk'  => 'required|string|max:255',
            'answers.*.answer_en'  => 'required|string|max:255',
            'answers.*.isCorrect'  => 'required|boolean',
            'tag_ids'         => 'sometimes|array',
            'tag_ids.*'       => 'integer|exists:tags,id',
        ]);

        $question = Question::create([
            'assignment_sk' => $data['assignment_sk'],
            'assignment_en' => $data['assignment_en'],
            'isMultiChoice' => $data['isMultiChoice'],
        ]);

        foreach ($data['answers'] as $ans) {
            $question->answers()->create([
                'answer_sk'  => $ans['answer_sk'],
                'answer_en'  => $ans['answer_en'],
                'isCorrect'  => $ans['isCorrect'],
            ]);
        }

        if (! empty($data['tag_ids'])) {
            $question->tags()->sync($data['tag_ids']);
        }

        return response()->json(
            $question->load(['answers', 'tags']),
            201
        );
    }

    /**
     * @OA\Put(
     *     path="/api/questions/{id}",
     *     summary="Update a question, its answers, and tags",
     *     tags={"Questions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the question",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"assignment_sk","assignment_en","isMultiChoice","tag_ids"},
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
     *         description="Updated",
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
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $data = $request->validate([
            'assignment_sk'   => 'required|string|max:1028',
            'assignment_en'   => 'required|string|max:1028',
            'isMultiChoice'   => 'required|boolean',
            'answers'         => 'array|min:1',
            'answers.*.answer_sk'  => 'required_with:answers|string|max:255',
            'answers.*.answer_en'  => 'required_with:answers|string|max:255',
            'answers.*.isCorrect'  => 'required_with:answers|boolean',
            'tag_ids'         => 'required|array|min:1',
            'tag_ids.*'       => 'integer|exists:tags,id',
        ]);

        if (isset($data['assignment_sk'])) {
            $question->assignment_sk = $data['assignment_sk'];
        }
        if (isset($data['assignment_en'])) {
            $question->assignment_en = $data['assignment_en'];
        }
        if (isset($data['isMultiChoice'])) {
            $question->isMultiChoice = $data['isMultiChoice'];
        }
        $question->save();

        if (array_key_exists('answers', $data)) {
            $question->answers()->delete();
            foreach ($data['answers'] as $ans) {
                $question->answers()->create([
                    'answer_sk'  => $ans['answer_sk'],
                    'answer_en'  => $ans['answer_en'],
                    'isCorrect'  => $ans['isCorrect'],
                ]);
            }
        }

        if (array_key_exists('tag_ids', $data)) {
            $question->tags()->sync($data['tag_ids'] ?? []);
        }

        return response()->json(
            $question->load(['answers', 'tags'])
        );
    }

    /**
     * @OA\Delete(
     *     path="/api/questions/{id}",
     *     summary="Delete a question and its answers",
     *     tags={"Questions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the question",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Question 1 successfully deleted.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->answers()->delete();
        $question->delete();

        return response()->json(["message" => "Question $id successfully deleted."], 200);
    }
}