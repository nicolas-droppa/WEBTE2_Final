<?php
// app/Http/Controllers/Admin/AdminController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Test;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Answer;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        // Aggregate counts
        $stats = [
            'users'     => User::count(),
            'tests'     => Test::count(),
            'questions' => Question::count(),
            'tags'      => Tag::count(),
            'answers'   => Answer::count(),
        ];

        // Fetch recent users for quick overview
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get(['id', 'name', 'email', 'created_at']);

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }

    protected function authorizeAdmin()
    {
        if (! auth()->user()?->isAdmin) {
            abort(403);
        }
    }
}
