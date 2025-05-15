<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Tag;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();
        
        $query = Question::with(['answers', 'tags']);

        if ($search = $request->input('search')) {
            $query->where('assignment_en', 'like', "%$search%")
                ->orWhere('assignment_sk', 'like', "%$search%");
        }

        if ($tagIds = $request->input('tags')) {
            foreach ($tagIds as $tagId) {
                $query->whereHas('tags', function ($q) use ($tagId) {
                    $q->where('tags.id', $tagId);
                });
            }
        }

        $questions = $query->get();
        $allTags = Tag::all();

        return view('admin.questions.index', compact('questions', 'allTags'));
    }

    public function edit(Question $question)
    {
        $this->authorizeAdmin();

        $question->load('answers');

        return view('admin.questions.edit', compact('question'));
    }


    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'assignment_sk' => 'required|string',
            'assignment_en' => 'required|string',
            'isMultiChoice' => 'required|boolean',
            'tags' => 'required|array',
            'tags.*.name_sk' => 'required|string',
            'tags.*.name_en' => 'required|string',
            'answers' => 'required|array',
            'answers.*.answer_sk' => 'required|string',
            'answers.*.answer_en' => 'required|string',
            'answers.*.isCorrect' => 'required|boolean',
        ]);


        // Create the question
        $question = Question::create([
            'assignment_sk' => $validated['assignment_sk'],
            'assignment_en' => $validated['assignment_en'],
            'isMultiChoice' => $validated['isMultiChoice'],
        ]);

        // Attach tags to the question
        foreach ($validated['tags'] as $tagData) {
            $tag = Tag::firstOrCreate([
                'name_sk' => $tagData['name_sk'],
                'name_en' => $tagData['name_en'],
            ]);
            $question->tags()->syncWithoutDetaching([$tag->id]);
        }

        // Store the answers as well (assuming you already have the logic)
        foreach ($validated['answers'] as $answerData) {
            $question->answers()->create([
                'answer_sk' => $answerData['answer_sk'],
                'answer_en' => $answerData['answer_en'],
                'isCorrect' => $answerData['isCorrect'] ?? false,
            ]);
        }

        return redirect()->route('admin.questions.index');
    }


    public function update(Request $request, Question $question)
    {
        $this->authorizeAdmin();
        //dd($request->all());
        // Validate the incoming data
        $validated = $request->validate([
            'assignment_sk' => 'required|string',
            'assignment_en' => 'required|string',
            'isMultiChoice' => 'required|boolean',
            'answers' => 'required|array|min:1',
            'answers.*.answer_sk' => 'required|string',
            'answers.*.answer_en' => 'required|string',
            'answers.*.isCorrect' => 'nullable|boolean',
            'answers.*.id' => 'nullable|string',
            'tags' => 'required|array',
            'tags.*.name_en' => 'required|string',
            'tags.*.name_sk' => 'required|string',
        ]);

        // Update the main question fields
        $question->update([
            'assignment_sk' => $validated['assignment_sk'],
            'assignment_en' => $validated['assignment_en'],
            'isMultiChoice' => $validated['isMultiChoice'],
        ]);

        // Handle answers: Update or create new ones, and delete removed ones
        $existingAnswerIds = $question->answers()->pluck('id')->toArray(); // Get existing answer IDs from DB
        $newAnswerIds = [];

        foreach ($validated['answers'] as $answerData) {
            $newAnswerIds[] = $answerData['id'] ?? null;

            // If an ID exists, try to update the answer
            if (isset($answerData['id']) && !empty($answerData['id'])) {
                $answer = $question->answers()->find($answerData['id']);
                if ($answer) {
                    // Update existing answer
                    $answer->update([
                        'answer_en' => $answerData['answer_en'],
                        'answer_sk' => $answerData['answer_sk'],
                        'isCorrect' => $answerData['isCorrect'] ?? false
                    ]);
                }
            } else {
                // Create a new answer if no ID is provided
                $question->answers()->create([
                    'answer_en' => $answerData['answer_en'],
                    'answer_sk' => $answerData['answer_sk'],
                    'isCorrect' => $answerData['isCorrect'] ?? false,
                ]);
            }
        }

        // Delete answers that are no longer part of the request
        $answersToDelete = array_diff($existingAnswerIds, $newAnswerIds);
        if (!empty($answersToDelete)) {
            $question->answers()->whereIn('id', $answersToDelete)->delete();
        }

        // Handle tags: sync new tags and remove old ones if necessary
        if (!empty($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagData) {
                $tag = Tag::firstOrCreate([
                    'name_sk' => $tagData['name_sk'],
                    'name_en' => $tagData['name_en'],
                ]);
                $tagIds[] = $tag->id;
            }
            $question->tags()->sync($tagIds);
        }


        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully.');
    }


    public function destroy(Question $question)
    {
        $this->authorizeAdmin();

        $question->answers()->delete(); // deletes related answers
        $question->delete();

        return redirect()->route('admin.questions.index');
    }

    protected function authorizeAdmin()
    {
        if (! auth()->user()?->isAdmin) {
            abort(403);
        }
    }
}
