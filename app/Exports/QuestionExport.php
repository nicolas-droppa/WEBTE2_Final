<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Question::all()->map(function ($question) {
            $tags = $question->tags->pluck('name_' . app()->getLocale())->implode(', ');

            return [
                $question->{'assignment_' . app()->getLocale()},
                $tags,
                $question->tests->count(),
                $question->tests->count() > 0
                ? round(($question->tests->where('pivot.isCorrect', true)->count() / $question->tests->count()) * 100) . ' %'
                : 'N/A',
                $this->formatAvgTime($question),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('history.question-text'),
            __('history.question-tag'),
            __('history.question-count'),
            __('history.question-success-rate'),
            __('history.question-avg-time'),
        ];
    }

    private function formatAvgTime($question)
    {
        $avgTime = $question->tests->avg('pivot.time');
        return $avgTime ? round($avgTime, 2) . ' s' : '-';
    }
}