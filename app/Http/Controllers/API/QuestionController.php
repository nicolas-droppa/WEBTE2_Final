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

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->answers()->delete();
        $question->delete();

        return response()->json(["message" => "Question $id successfully deleted."]);
    }
}
