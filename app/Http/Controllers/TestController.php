<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $q = Test::query();
        if ($search = $request->query('search')) {
            $q->where('title', 'like', "%{$search}%");
        }
        $tests = $q->orderBy('created_at', 'desc')
                   ->paginate(10);

        return view('tests.index', compact('tests'));
    }

    public function create()
    {
        $questions = Question::all();
        return view('tests.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'questions'   => 'required|array|min:1',
            'questions.*' => 'exists:questions,id',
        ]);

        $test = Test::create(['title' => $data['title']]);
        $test->questions()->sync($data['questions']);

        return redirect()->route('tests.index')
                         ->with('success', 'Test bol úspešne vytvorený.');
    }

    public function edit(Test $test)
    {
        $questions = Question::all();
        $selectedQuestions = $test->questions->pluck('id')->toArray();

        return view('tests.edit', compact('test', 'questions', 'selectedQuestions'));
    }

    public function update(Request $request, Test $test)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'questions'   => 'required|array|min:1',
            'questions.*' => 'exists:questions,id',
        ]);

        $test->update([
            'title' => $data['title'],
        ]);

        $test->questions()->sync($data['questions']);

        return redirect()
            ->route('tests.index')
            ->with('success', 'Test bol úspešne aktualizovaný.');
    }

    public function destroy(Test $test)
    {
        $test->questions()->detach();

        $test->delete();

        return redirect()
            ->route('tests.index')
            ->with('success', 'Test bol zmazaný.');
    }
}
