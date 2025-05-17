<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HistoryTest;
use Illuminate\Http\Request;

class HistoryTestQuestionController extends Controller
{
    // List question‐records for one attempt
    public function index(HistoryTest $history_test)
    {
        $records = $history_test->questions()
            ->withPivot(['answer_id','written_answer','time'])
            ->get()
            ->map(fn($q) => [
                'question' => $q,
                'pivot'    => $q->pivot,
            ]);

        return response()->json(['questions' => $records]);
    }

    // Record one question’s answer/time
    public function store(Request $request, HistoryTest $history_test)
    {
        $data = $request->validate([
            'question_id'    => 'required|exists:questions,id',
            'answer_id'      => 'nullable|exists:answers,id',
            'written_answer' => 'nullable|string|max:255',
            'time'           => 'required|numeric|min:0',
        ]);

        $history_test->questions()
            ->attach($data['question_id'], [
                'answer_id'      => $data['answer_id'] ?? null,
                'written_answer' => $data['written_answer'] ?? null,
                'time'           => $data['time'],
            ]);

        $new = $history_test->questions()
            ->where('question_id',$data['question_id'])
            ->withPivot(['answer_id','written_answer','time'])
            ->first();

        return response()->json([
            'question' => $new,
            'pivot'    => $new->pivot
        ], 201);
    }

    // Show one question‐record
    public function show(HistoryTest $history_test, $question_id)
    {
        $record = $history_test->questions()
            ->where('question_id',$question_id)
            ->withPivot(['answer_id','written_answer','time'])
            ->firstOrFail();

        return response()->json([
            'question' => $record,
            'pivot'    => $record->pivot
        ]);
    }

    // Update answer/time for one question‐record
    public function update(Request $request, HistoryTest $history_test, $question_id)
    {
        $data = $request->validate([
            'answer_id'      => 'sometimes|exists:answers,id',
            'written_answer' => 'sometimes|string|max:255',
            'time'           => 'sometimes|numeric|min:0',
        ]);

        $history_test->questions()
            ->updateExistingPivot($question_id, $data);

        $updated = $history_test->questions()
            ->where('question_id',$question_id)
            ->withPivot(['answer_id','written_answer','time'])
            ->first();

        return response()->json([
            'question' => $updated,
            'pivot'    => $updated->pivot
        ]);
    }

    // Remove one question‐record
    public function destroy(HistoryTest $history_test, $question_id)
    {
        $history_test->questions()->detach($question_id);
        return response()->json(['message'=>'Record deleted.']);
    }
}

