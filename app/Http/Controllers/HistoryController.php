<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;

use App\Exports\QuestionExport;
use App\Exports\TestExport;
use Maatwebsite\Excel\Facades\Excel;


class HistoryController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin) {
            return redirect('/');
        } 

        $tests = Test::get();

        $questions = Question::get();

        return view('history.index', compact('tests', 'questions'));
    }

    public function exportQuestions()
    {
        return Excel::download(new QuestionExport, 'questions.csv');
    }

    public function exportTests()
    {
        return Excel::download(new TestExport, 'tests.csv');
    }

    public function showTest($id)
    {
        $test = Test::with(['user', 'questions.answers', 'questions.tags'])->findOrFail($id);

        $questions = Question::get();

        return view('history.tests.show', compact('test', 'questions'));

    }
}
