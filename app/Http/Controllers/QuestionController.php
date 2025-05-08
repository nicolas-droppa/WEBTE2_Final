<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('answers')->get();
        return view('questions.index', compact('questions'));
    }

    public function edit(Question $question)
    {
        $question->load('answers');

        return view('questions.edit', compact('question'));
    }


    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'assignment_sk' => 'required|string',
            'assignment_en' => 'required|string',
            'isMultiChoice' => 'nullable|boolean',
            'answers.*.answer' => 'required|string',
            'answers.*.isCorrect' => 'nullable|boolean',
        ]);

        $question = Question::create([
            'assignment_sk' => $data['assignment_sk'],
            'assignment_en' => $data['assignment_en'],
            'isMultiChoice' => $data['isMultiChoice'] ?? false,
        ]);

        foreach ($data['answers'] as $answerData) {
            $question->answers()->create($answerData);
        }

        return redirect()->route('questions.index');
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'assignment_sk' => 'required|string',
            'assignment_en' => 'required|string',
            'isMultiChoice' => 'required|boolean',
            'answers' => 'required|array|min:1',
            'answers.*.answer' => 'required|string',
            'answers.*.isCorrect' => 'required|boolean',
        ]);

        $question->update([
            'assignment_sk' => $validated['assignment_sk'],
            'assignment_en' => $validated['assignment_en'],
            'isMultiChoice' => $validated['isMultiChoice'],
        ]);

        // Delete old answers
        $question->answers()->delete();

        // Create updated answers
        foreach ($validated['answers'] as $answerData) {
            $question->answers()->create($answerData);
        }

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->answers()->delete(); // deletes related answers
        $question->delete();

        return redirect()->route('questions.index');
    }
}
