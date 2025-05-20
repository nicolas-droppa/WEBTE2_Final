<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tests",
     *     summary="Get a list of tests (optionally filter by title)",
     *     tags={"Tests"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Search by test title",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of tests",
     *         @OA\JsonContent(
     *             @OA\Property(property="tests", type="array", @OA\Items(ref="#/components/schemas/Test"))
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Test::with('questions');
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }
        $tests = $query->get();
        return response()->json([
            'tests' => $tests,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/tests",
     *     summary="Create a new test with question IDs",
     *     tags={"Tests"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","question_ids"},
     *             @OA\Property(property="title", type="string", example="Math Test"),
     *             @OA\Property(
     *                 property="question_ids",
     *                 type="array",
     *                 @OA\Items(type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Test created",
     *         @OA\JsonContent(ref="#/components/schemas/Test")
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
            'title'         => 'required|string|max:255',
            'question_ids'  => 'required|array|min:1',
            'question_ids.*'=> 'exists:questions,id',
        ]);

        $test = Test::create([
            'title' => $data['title'],
        ]);

        if (! empty($data['question_ids'])) {
            $test->questions()->attach($data['question_ids']);
        }

        return response()->json($test->load('questions'), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tests/{test}",
     *     summary="Get a single test with its questions",
     *     tags={"Tests"},
     *     @OA\Parameter(
     *         name="test",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Test resource",
     *         @OA\JsonContent(ref="#/components/schemas/Test")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show(Test $test)
    {
        return $test->load('questions');
    }

    /**
     * @OA\Put(
     *     path="/api/tests/{test}",
     *     summary="Update a test's title and question IDs",
     *     tags={"Tests"},
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
     *             required={"title","question_ids"},
     *             @OA\Property(property="title", type="string", example="New Math Test"),
     *             @OA\Property(
     *                 property="question_ids",
     *                 type="array",
     *                 @OA\Items(type="integer", example=2)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Test updated",
     *         @OA\JsonContent(ref="#/components/schemas/Test")
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
    public function update(Request $request, Test $test)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'question_ids'  => 'required|array|min:1',
            'question_ids.*'=> 'exists:questions,id',
        ]);

        if (isset($data['title'])) {
            $test->update(['title' => $data['title']]);
        }

        if (array_key_exists('question_ids', $data)) {
            $test->questions()->sync($data['question_ids']);
        }

        return $test->load('questions');
    }

    /**
     * @OA\Delete(
     *     path="/api/tests/{test}",
     *     summary="Delete a test and detach its questions",
     *     tags={"Tests"},
     *     @OA\Parameter(
     *         name="test",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Test deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function destroy(Test $test)
    {
        $test->questions()->detach();
        $test->delete();

        return response()->json([
            'message' => 'Test deleted successfully.'
        ], 200);
    }
}