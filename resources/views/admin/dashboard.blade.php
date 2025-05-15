@extends('layouts.admin')

{{-- resources/views/admin/dashboard.blade.php --}}
@section('content')
<div class="max-w-5xl mx-auto px-6 mt-16 mb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <h1 class="text-4xl font-bold text-slate-800 dark:text-gray-100">
            <i class="fas fa-tachometer-alt mr-2 text-[#54b5ff] dark:text-[#54b5ff]"></i>
            {{ __('admin.dashboard_title') }}
        </h1>
    </div>

    <!-- Stats Section -->
    <div class="bg-white dark:bg-[#1c1c1e] p-8 rounded-xl shadow-md border border-slate-200 dark:border-[#141414] mb-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($stats as $key => $value)
                <div class="flex flex-col items-center bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                    <span class="text-3xl font-semibold text-gray-800 dark:text-gray-200">{{ $value }}</span>
                    <span class="mt-2 text-base uppercase text-gray-500 dark:text-gray-400">
                        {{ __('admin.stats.' . $key) }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Users Section -->
    <div class="bg-white dark:bg-[#1c1c1e] p-8 rounded-xl shadow-md border border-slate-200 dark:border-[#141414]">
        <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-100 mb-6">
            {{ __('admin.recent_users') }}
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('admin.table.id') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('admin.table.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('admin.table.email') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('admin.table.joined_at') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentUsers as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $user->created_at->format('d.m.Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection