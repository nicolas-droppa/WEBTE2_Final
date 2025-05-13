<?php

namespace App\Exports;

use App\Models\HistoryTest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // load the user, plus the pivot data for questions so we can avg the time
        return HistoryTest::with('user','questions')
            ->get()
            ->map(function (HistoryTest $attempt) {
                // average time across all questions in this specific test-attempt
                $avgTime = $attempt->questions->avg('pivot.time');

                return [
                    'User'      => $attempt->user->name,
                    'Test Title'=> $attempt->test->title,
                    'Score'     => $attempt->score,
                    'Avg Time'  => $avgTime ? round($avgTime, 2).' s' : '-',
                    'Date'      => $attempt->created_at->format('Y-m-d H:i'),
                    'City'      => $attempt->city,
                    'State'     => $attempt->state,
                ];
            });
    }

    public function headings(): array
    {
        return [
            __('history.user-name'),
            __('history.test-title'),
            __('history.score'),
            __('history.question-avg-time'),
            __('history.time'),
            __('history.city'),
            __('history.state'),
        ];
    }
}
