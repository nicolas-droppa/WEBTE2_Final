 @php
    $lang = app()->getLocale();
@endphp

<div class="overflow-x-auto">
    <table class="min-w-full bg-white text-left text-sm text-slate-800 dark:text-slate-200 dark:bg-[#343434] shadow rounded-lg">
        <thead class="bg-gray-100 text-slate-700 dark:text-slate-300 dark:bg-[#2a2a2a]">
            <tr>
                {{-- <th class="px-4 py-2">{{ __('history.question-id') }}</th> --}}
                <th class="px-4 py-2">{{ __('history.question-text') }}</th>
                <th class="px-4 py-2">{{ __('history.question-tag') }}</th>
                <th class="px-4 py-2">{{ __('history.question-count') }}</th>
                <th class="px-4 py-2">{{ __('history.question-success-rate') }}</th>
                <th class="px-4 py-2">{{ __('history.question-avg-time') }}</th>
                <th class="px-4 py-2 w-2"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $q)
                <tr class="border-b hover:bg-gray-50 dark:border-[#2a2a2a] dark:md:hover:bg-[#2e2e2e]">
                    {{-- <td class="px-4 py-2">{{$q->id}}</td> --}}
                    <td class="px-4 py-2">
                        <div class="max-w-[320px] overflow-y-hidden overflow-x-auto text-[10px]">
                            {!! '$' . $q->{'assignment_' . $lang} . '$' !!}
                        </div>
                    </td> 
                    <td class="px-4 py-2">
                        @if ($q->tags->isNotEmpty())
                            <ul class="flex flex-wrap gap-2">
                                @foreach ($q->tags as $tag)
                                    <li class="text-xs font-medium px-3 py-1 rounded-full border border-[#54b5ff]
                                            bg-[#e6f4ff] dark:bg-[#133c4d] text-[#1e4b6d] dark:text-[#8bd4ff]">
                                        {{ $tag->{'name_' . $lang} }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif</td>
                    <td class="px-4 py-2">
                        {{ $q->tests->count() }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $q->tests->count() > 0 ? round($q->tests->filter(fn($t) => $q->answers->firstWhere('id', $t->pivot->answer_id)?->isCorrect)->count() / $q->tests->count() * 100) . ' %' : '-' }}
                    </td>
                    <td class="px-4 py-2">
                        @php
                            $avgTime = $q->tests->avg('pivot.time');
                        @endphp
                        {{ $avgTime ? round($avgTime, 2) . ' s' : '-' }}    
                    </td>
                    <td class="px-4 py-2 w-2">
                        <a href="{{ route('admin.history.questions.show', ['id' => $q->id]) }}" class="text-xs font-medium py-1 px-3 rounded-md bg-[#dcf0ff] hover:bg-[#bde5ff] dark:bg-[#1e2b3a] text-[#1e3a5f] dark:text-[#9ec9ff]">
                            {{ __('history.details-btn') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/katex.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/contrib/auto-render.min.js"
        onload="renderMathInElement(document.body, {
            delimiters: [
                {left: '$$', right: '$$', display: true},
                {left: '$', right: '$', display: false}
            ]
        });">
</script>
@endsection

