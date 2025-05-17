<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class TestQuestionController extends Controller
{
    /**
     * GET /tests/{test}/questions
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
     * GET /tests/{test}/questions/{question}
     */
    public function show(Test $test, Question $question)
    {
        // ensure the question actually belongs to this test
        $test->questions()->findOrFail($question->id);

        return response()->json(
            $question->load(['answers','tags'])
        );
    }

    /**
     * POST /tests/{test}/questions
     *
     * Create a new question AND attach it to the test.
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

        // 1) create the question
        $question = Question::create([
            'assignment_sk' => $data['assignment_sk'],
            'assignment_en' => $data['assignment_en'],
            'isMultiChoice' => $data['isMultiChoice'],
        ]);

        // 2) its answers
        foreach ($data['answers'] as $ans) {
            $question->answers()->create($ans);
        }

        // 3) its tags
        if (!empty($data['tag_ids'])) {
            $question->tags()->sync($data['tag_ids']);
        }

        // 4) attach to the test
        $test->questions()->attach($question->id);

        return response()->json(
            $question->load(['answers','tags']),
            201
        );
    }

    /**
     * PUT/PATCH /tests/{test}/questions/{question}
     *
     * Update a question (that belongs to this test).
     */
    public function update(Request $request, Test $test, Question $question)
    {
        // ensure it belongs
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

        // update question fields
        $question->update([
            'assignment_sk' => $data['assignment_sk'],
            'assignment_en' => $data['assignment_en'],
            'isMultiChoice' => $data['isMultiChoice'],
        ]);

        // replace answers if provided
        if (array_key_exists('answers',$data)) {
            $question->answers()->delete();
            foreach ($data['answers'] as $ans) {
                $question->answers()->create($ans);
            }
        }

        // sync tags if provided
        if (array_key_exists('tag_ids',$data)) {
            $question->tags()->sync($data['tag_ids']);
        }

        return response()->json(
            $question->load(['answers','tags'])
        );
    }

    /**
     * DELETE /tests/{test}/questions/{question}
     *
     * Detach from test AND delete the question entirely.
     */
    public function destroy(Test $test, Question $question)
    {
        // ensure it belongs
        $test->questions()->findOrFail($question->id);

        // detach & delete
        $test->questions()->detach($question->id);
        $question->answers()->delete();
        $question->tags()->detach();
        $question->delete();

        return response()->json([
            'message' => "Question {$question->id} removed and deleted."
        ], 200);
    }
}
