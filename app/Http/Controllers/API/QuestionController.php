<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
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

        // Fetch the filtered questions
        $questions = $query->get();

        // Return as JSON response
        return response()->json([
            'questions' => $questions,
        ]);
    }

    public function show($id)
    {
        // Eager load 'answers' and 'tags' relationships
        $question = Question::with(['answers', 'tags'])->findOrFail($id);

        return response()->json($question);
    }

    /**
     * Create a new question along with its answers and tags.
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

        // 1. Create the question
        $question = Question::create([
            'assignment_sk' => $data['assignment_sk'],
            'assignment_en' => $data['assignment_en'],
            'isMultiChoice' => $data['isMultiChoice'],
        ]);

        // 2. Create related answers
        foreach ($data['answers'] as $ans) {
            $question->answers()->create([
                'answer_sk'  => $ans['answer_sk'],
                'answer_en'  => $ans['answer_en'],
                'isCorrect'  => $ans['isCorrect'],
            ]);
        }

        // 3. Attach tags if provided
        if (! empty($data['tag_ids'])) {
            $question->tags()->sync($data['tag_ids']);
        }

        // 4. Return the full resource
        return response()->json(
            $question->load(['answers', 'tags']),
            201
        );
    }

    /**
     * Update an existing question, its answers, and tags.
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

        // 1. Update fields on question
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

        // 2. If answers key present, replace all existing answers
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

        // 3. Sync tags if provided (or detach all if empty array)
        if (array_key_exists('tag_ids', $data)) {
            $question->tags()->sync($data['tag_ids'] ?? []);
        }

        return response()->json(
            $question->load(['answers', 'tags'])
        );
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->answers()->delete();
        $question->delete();

        return response()->json(["message" => "Question $id successfully deleted."], 200);
    }
}
