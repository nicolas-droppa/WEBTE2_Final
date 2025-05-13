<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Question::with('tags','historyTests')->get()->map(function ($question) {
            // tags in current locale
            $tags = $question->tags
                             ->pluck('name_' . app()->getLocale())
                             ->implode(', ');

            // use historyTests instead of tests
            $attempts     = $question->historyTests;
            $count        = $attempts->count();
            $correctCount = $attempts->where('pivot.isCorrect', true)->count();
            $avgTime      = $attempts->avg('pivot.time');

            return [
                $question->{'assignment_' . app()->getLocale()},
                $tags,
                $count,
                $count
                    ? round($correctCount / $count * 100) . ' %'
                    : 'N/A',
                $avgTime ? round($avgTime, 2) . ' s' : '-',
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
}
