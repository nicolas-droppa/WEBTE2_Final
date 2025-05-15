<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $q = Test::query();
        if ($search = $request->query('search')) {
            $q->where('title', 'like', "%{$search}%");
        }
        $tests = $q->orderBy('created_at', 'desc')
                   ->paginate(10);

        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $questions = Question::all();
        return view('admin.tests.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'questions'   => 'required|array|min:1',
            'questions.*' => 'exists:questions,id',
        ]);

        $test = Test::create(['title' => $data['title']]);
        $test->questions()->sync($data['questions']);

        return redirect()->route('admin.tests.index')
                         ->with('success', 'Test bol úspešne vytvorený.');
    }

    public function edit(Test $test)
    {
        $this->authorizeAdmin();

        $questions = Question::all();
        $selectedQuestions = $test->questions->pluck('id')->toArray();

        return view('admin.tests.edit', compact('test', 'questions', 'selectedQuestions'));
    }

    public function update(Request $request, Test $test)
    {
        $this->authorizeAdmin();
        
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
            ->route('admin.tests.index')
            ->with('success', 'Test bol úspešne aktualizovaný.');
    }

    public function destroy(Test $test)
    {
        $this->authorizeAdmin();
        
        $test->questions()->detach();

        $test->delete();

        return redirect()
            ->route('admin.tests.index')
            ->with('success', 'Test bol zmazaný.');
    }

    protected function authorizeAdmin()
    {
        if (! auth()->user()?->isAdmin) {
            abort(403);
        }
    }
}
