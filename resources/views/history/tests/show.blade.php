{{-- @extends('layouts.app')

@section('content')

<div class="container">
    <h1>Test Detail</h1>

    <p><strong>User:</strong> {{ $test->user->name }}</p>
    <p><strong>Created At:</strong> {{ $test->created_at }}</p>

    <h2>Questions</h2>
    <ul>
        @foreach ($test->questions as $question)
            <li>
                <p><strong>{{ $question->assignment_en }}</strong></p>

                <ul>
                    @foreach ($question->answers as $answer)
                        <li>        
                            {{ $answer->answer }} 
                            @if ($answer->isCorrect)
                                <strong>(Correct)</strong>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <p>
                    <strong>Answered:</strong>
                    @if ($question->pivot->isCorrect)
                        <span class="text-success">Correctly</span>
                    @else
                        <span class="text-danger">Incorrectly</span>
                    @endif
                </p>

                <p>Tags: 
                    @foreach ($question->tags as $tag)
                        <span>{{ $tag->name_en }}</span>@if (!$loop->last), @endif
                    @endforeach
                </p>
            </li>
        @endforeach
    </ul>
</div>

@endsection
 --}}

 @extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 mt-16 mb-20">
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-slate-800 dark:text-gray-100">
            <i class="fas fa-file-alt mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
            Test Detail
        </h1>
    </div>

    <!-- Test Info -->
    <div class="bg-white dark:bg-[#1c1c1e] shadow-md rounded-xl p-6 border border-slate-200 dark:border-[#141414] mb-10">
        <p class="text-slate-700 dark:text-slate-300">
            <strong>User:</strong> {{ $test->user->name }}
        </p>
        <p class="text-slate-700 dark:text-slate-300">
            <strong>Created At:</strong> {{ $test->created_at }}
        </p>
    </div>

    <!-- Questions -->
    @php $lang = app()->getLocale(); @endphp

    <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-100 mb-4">Questions</h2>

    @foreach ($test->questions as $question)
        <div class="bg-white dark:bg-[#1c1c1e] shadow-md rounded-xl p-6 mb-6 border border-slate-200 dark:border-[#141414] space-y-4">
            
            <!-- Assignment -->
            <div class="pl-3 border-l-4 border-[#54b5ff]">
                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-1">Assignment</p>
                <p class="text-sm text-slate-700 dark:text-slate-300 italic">
                    {!! '$' . $question->{'assignment_en'} . '$' !!}
                </p>
            </div>

            <!-- Tags -->
            @if ($question->tags->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    @foreach ($question->tags as $tag)
                        <span class="text-xs font-medium px-3 py-1 rounded-full border border-[#54b5ff]
                                     bg-[#e6f4ff] dark:bg-[#133c4d] text-[#1e4b6d] dark:text-[#8bd4ff]">
                            {{ $tag->name_en }}
                        </span>
                    @endforeach
                </div>
            @endif

            <!-- Answers -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach ($question->answers as $answer)
                    <div class="flex items-center gap-2 p-2 rounded-lg
                        {{ $answer->isCorrect ? 'bg-green-100 dark:bg-green-900/30' : 'bg-slate-50 dark:bg-[#2a2a2a]' }}">
                        <span class="text-slate-800 dark:text-slate-100 text-sm">
                            {!! '$' . $answer->answer . '$' !!}
                        </span>
                        @if($answer->isCorrect)
                            <i class="fas fa-check text-green-600"></i>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Answered Correctly -->
            <p class="text-sm">
                <strong>Answered:</strong>
                @if ($question->pivot->isCorrect)
                    <span class="text-green-600 dark:text-green-400">Correctly</span>
                @else
                    <span class="text-red-600 dark:text-red-400">Incorrectly</span>
                @endif
            </p>
        </div>
    @endforeach
</div>
@endsection

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
