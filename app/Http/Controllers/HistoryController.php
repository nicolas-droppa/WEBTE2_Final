<?php

namespace App\Http\Controllers;

use App\Models\HistoryTest;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Exports\QuestionExport;
use App\Exports\TestExport;
use Maatwebsite\Excel\Facades\Excel;

class HistoryController extends Controller
{
    /** GET /history */
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        // pull all history‐attempts in place of Test::get()
        $tests = HistoryTest::with('user','test')->get();

        // pull all questions + their history pivot
        $qs = Question::with('answers','tags','historyTests')->get();
        // alias historyTests → tests so your old blade still uses $q->tests
        $qs->each(fn($q) => $q->setRelation('tests', $q->historyTests));

        return view('admin.history.index', [
            'tests'     => $tests,
            'questions' => $qs,
        ]);
    }

    /** GET /history/export-questions */
    public function exportQuestions()
    {
        $this->authorizeAdmin();
        // your existing QuestionExport, now using historyTests internally
        return Excel::download(new QuestionExport, 'questions.csv');
    }

    /** GET /history/export-test */
    public function exportTests()
    {
        $this->authorizeAdmin();
        // swap in a HistoryTestExport that uses the HistoryTest model
        return Excel::download(new TestExport, 'tests.csv');
    }

    /** GET /history/tests/{id} */
    public function showTest($id)
    {
        $this->authorizeAdmin();

        // load the specific history‐attempt
        $attempt = HistoryTest::with([
            'user',
            'test.questions.answers',
            'test.questions.tags',
            'questions'  // this is the pivot
        ])->findOrFail($id);

        // alias it to $test for your view
        $test      = $attempt;
        $questions = $attempt->questions;

        return view('admin.history.tests.show', compact('test','questions'));
    }

    /** GET /history/questions/{id} */
    public function showQuestion($id)
    {
        $this->authorizeAdmin();

        $question = Question::with('answers','tags','historyTests')
                            ->findOrFail($id);

        // alias historyTests → tests so your view’s $question->tests works
        $question->setRelation('tests', $question->historyTests);

        return view('admin.history.questions.show', compact('question'));
    }

    /** simple admin check pulled into one place */
    protected function authorizeAdmin()
    {
        if (! auth()->user()?->isAdmin) {
            abort(403);
        }
    }
}
