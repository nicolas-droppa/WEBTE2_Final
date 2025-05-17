<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with the base query, eager‐loading questions
        $query = Test::with('questions');

        // If a `search` param is present, filter on title
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        // Execute and return
        $tests = $query->get();

        return response()->json([
            'tests' => $tests,
        ]);
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Test $test)
    {
        return $test->load('questions');
    }

    /**
     * Update the specified resource in storage.
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
            // sync questions (add/remove as needed)
            $test->questions()->sync($data['question_ids']);
        }

        return $test->load('questions');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        // detach pivot and delete
        $test->questions()->detach();
        $test->delete();

        return response()->json([
            'message' => 'Test deleted successfully.'
        ], 200);
    }
}
