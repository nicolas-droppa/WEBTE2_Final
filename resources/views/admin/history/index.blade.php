@extends('layouts.admin')


@section('content')

<div class="max-w-5xl mx-auto px-6 mt-8 mb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
        <h1 class="text-3xl font-bold text-slate-800 dark:text-gray-100">
            <i class="fas fa-list-ul mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
            {{ __('history.overview-heading') }}
        </h1>
        <div class="flex justify-end mt-4">
            <a href="{{ route('export-tests') }}"
            class="text-gray-500 pr-4 text-xs font-semibold">
                <i class="fas fa-download mr-1"></i> {{ __('history.tests-export-btn') }}
            </a>
        </div>
    </div>

    @include('admin.history.tables.tests')

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 my-8">
        <h1 class="text-3xl font-bold text-slate-800 dark:text-gray-100">
            <i class="fas fa-question-circle mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
            {{ __('history.questions-heading') }}
        </h1>
        <div class="flex justify-end mt-4">
            <a href="{{ route('export-questions') }}"
            class="text-gray-500 pr-4 text-xs font-semibold">
                <i class="fas fa-download mr-1"></i> {{ __('history.questions-export-btn') }}
            </a>
        </div>
    </div>

    @include('admin.history.tables.questions')

    <div class="flex justify-center mt-4">
        <form method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="text-slate-800 dark:text-gray-100 text-sm font-semibold rounded-md transition duration-200">
                <i class="fas fa-trash-alt mr-1"></i> {{ __('history.clear-history-btn') }}
            </button>
        </form>
    </div>

</div>

@endsection
