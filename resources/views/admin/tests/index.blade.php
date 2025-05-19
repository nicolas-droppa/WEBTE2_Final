<!-- TODO: RETURN USER IG NOT ADMIN -->

@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-6 mt-16 mb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <h1 class="text-4xl font-bold text-slate-800 dark:text-gray-100">
            <i class="fas fa-list-ul mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
            {{ __('tests.title') }}
        </h1>
        <a href="{{ route('admin.tests.create') }}"
            class="bg-[#54b5ff] text-white px-4 py-2 rounded hover:bg-[#3ca5ec] transition shadow flex items-center gap-2">
            <i class="fas fa-plus"></i> {{ __('tests.create') }}
        </a>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('admin.tests.index') }}"
        class="mb-10 bg-white dark:bg-[#1c1c1e] p-8 rounded-xl shadow-md border border-slate-200 dark:border-[#141414]">
        <div>
            <label for="search"
                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                <i class="fas fa-search mr-1 text-[#54b5ff] dark:text-[#54b5ff]"></i>
                {{ __('tests.search_label') }}
            </label>
            <div class="flex">
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('tests.search_placeholder') }}"
                    class="w-full border border-slate-300 dark:border-slate-600 dark:bg-[#2a2a2a] dark:text-white rounded-l-md px-3 py-2 shadow-sm focus:ring-[#54b5ff] focus:border-[#54b5ff]">
                <button type="submit"
                    class="inline-block bg-[#54b5ff] text-white px-6 py-2 rounded-r-md hover:bg-[#3ca5ec] transition shadow">
                    <i class="fas fa-filter mr-1"></i> {{ __('tests.filter_button') }}
                </button>
            </div>
        </div>
    </form>

    <!-- Tests List -->
    @foreach ($tests as $test)
    <div class="bg-white dark:bg-[#1c1c1e] shadow-md rounded-xl p-6 mb-6 border border-slate-200 dark:border-[#141414]">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100 mb-1">
                    {{ $test->title }}
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('tests.created_at', ['date' => $test->created_at->format('d.m.Y')]) }}
                </p>
            </div>
            <div class="flex gap-3 items-center">
                {{-- Start Test button --}}
                <a href="{{ route('tests.start', $test->id) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-3 rounded transition"
                    title="{{ __('tests.start_test') }}">
                    {{ __('Start Test') }}
                </a>

                {{-- Edit Test --}}
                <a href="{{ route('admin.tests.edit', $test) }}"
                    class="text-yellow-500 hover:text-yellow-600 transition text-lg"
                    title="{{ __('tests.edit') }}">
                    <i class="fas fa-edit"></i>
                </a>

                {{-- Delete Test --}}
                <form method="POST" action="{{ route('admin.tests.destroy', $test) }}"
                    onsubmit="return confirm('{{ __('tests.delete_confirm') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-red-500 hover:text-red-600 transition text-lg"
                        title="{{ __('tests.delete') }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach


    <!-- Pagination -->
    <div class="mt-4">
        {{ $tests->appends(request()->except('page'))->links() }}
    </div>
</div>
@endsection