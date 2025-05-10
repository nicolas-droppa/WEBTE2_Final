<?php

namespace App\Exports;

use App\Models\Test;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Test::with('user', 'questions')->get()->map(function ($test) {
            $avgTime = $test->questions->avg('pivot.time');

            return [
                $test->user->name,
                $test->score,
                $avgTime ? round($avgTime, 2) . ' s' : '-',
                $test->created_at->format('Y-m-d H:i'),
                'Mesto, Krajina',
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('history.user-name'),
            __('history.score'),
            __('history.avg-time'),
            __('history.time'),
            __('history.place'),
        ];
    }
}