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
}
