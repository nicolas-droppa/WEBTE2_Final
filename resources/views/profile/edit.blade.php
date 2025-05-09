@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-16 mb-20 px-6">
        <h1 class="text-4xl font-bold mb-6 text-slate-800 dark:text-gray-100">
            {{ __('profile.title') }}
        </h1>
        <p class="text-lg text-slate-600 dark:text-gray-300 mb-10">
            {{ __('profile.description') }}
        </p>

        <div class="bg-white dark:bg-[#1c1c1e] rounded-xl shadow-md p-8 space-y-8 border border-slate-200 dark:border-[#141414]">

            {{-- Profile Information --}}
            <section class="space-y-4">
                <h2 class="text-2xl font-semibold text-[#54b5ff] dark:text-[#54b5ff] border-b pb-2 dark:border-[#141414]">
                    <i class="fas fa-user-circle mr-2 text-[#54b5ff]"></i>
                    {{ __('profile.update_information') }}
                </h2>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </section>

            {{-- Update Password --}}
            <section class="space-y-4">
                <h2 class="text-2xl font-semibold text-[#54b5ff] dark:text-[#54b5ff] border-b pb-2 dark:border-[#141414]">
                    <i class="fas fa-lock mr-2 text-[#54b5ff]"></i>
                    {{ __('profile.update_password') }}
                </h2>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </section>

            {{-- Delete Account --}}
            <section class="space-y-4">
                <h2 class="text-2xl font-semibold text-[#54b5ff] dark:text-[#54b5ff] border-b pb-2 dark:border-[#141414]">
                    <i class="fas fa-trash-alt mr-2 text-[#54b5ff]"></i>
                    {{ __('profile.delete_account') }}
                </h2>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </section>

        </div>
    </div>
@endsection
