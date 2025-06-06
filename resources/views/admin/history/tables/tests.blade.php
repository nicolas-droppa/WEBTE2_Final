<div class="overflow-x-auto">
    <table class="min-w-full bg-white text-left text-sm text-slate-800 dark:text-slate-200 dark:bg-[#343434] shadow rounded-lg">
        <thead class="bg-gray-100 text-slate-700 dark:text-slate-300 dark:bg-[#2a2a2a]">
            <tr>
                {{-- <th class="px-4 py-2">{{ __('history.test-id') }}</th> --}}
                <th class="px-4 py-2">{{ __('history.test-title') }}</th>
                <th class="px-4 py-2">{{ __('history.user-name') }}</th>
                <th class="px-4 py-2">{{ __('history.score') }}</th>
                <th class="px-4 py-2">{{ __('history.avg-time') }}</th>
                <th class="px-4 py-2">{{ __('history.time') }}</th>
                <th class="px-4 py-2">{{ __('history.place') }}</th>
                <th class="px-4 py-2 w-2"></th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($tests as $test)
                <tr class="border-b hover:bg-gray-50 dark:border-[#2a2a2a] dark:md:hover:bg-[#2e2e2e]">
                    {{-- <td class="px-4 py-2">{{ $test->id }}</td> --}}
                    <td class="px-4 py-2">{{ $test->test->title }}</td>
                    <td class="px-4 py-2">{{ $test->user->name ?? __('test.anonym') }}</td>
                    <td class="px-4 py-2">{{ $test->score }}</td>
                    <td class="px-4 py-2">
                        @php
                            $avgTime = $test->questions->avg('pivot.time');
                        @endphp
                        {{ $avgTime ? round($avgTime, 2) . ' s' : '-' }}
                    </td>
                    <td class="px-4 py-2">{{ $test->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2">{{ $test->city }}, {{ $test->state }}</td>
                    
                    <td class="px-4 py-2 w-2">
                        <a href="{{ route('admin.history.tests.show', ['id' => $test->id]) }}" class="cursor-pointer text-xs font-medium py-1 px-3 rounded-md bg-[#dcf0ff] hover:bg-[#bde5ff] dark:bg-[#1e2b3a] text-[#1e3a5f] dark:text-[#9ec9ff]">
                            {{ __('history.details-btn') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>