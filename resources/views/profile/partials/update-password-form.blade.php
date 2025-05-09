<section class="space-y-4">
    <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
        <i class="fas fa-key mr-2 text-[#54b5ff]"></i>
        {{ __('profile.update_password_title') }}
    </h3>

    <p class="text-slate-700 dark:text-gray-400">
        {{ __('profile.update_password_description') }}
    </p>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6 mt-4">
        @csrf
        @method('put')

        {{-- Current password --}}
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-slate-800 dark:text-gray-100">
                {{ __('profile.current_password') }}
            </label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-[#2c2c2e] border border-gray-300 dark:border-[#3a3a3c] text-slate-800 dark:text-gray-100 focus:ring-2 focus:ring-[#54b5ff] focus:outline-none px-3 py-2 transition"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New password --}}
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-slate-800 dark:text-gray-100">
                {{ __('profile.new_password') }}
            </label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-[#2c2c2e] border border-gray-300 dark:border-[#3a3a3c] text-slate-800 dark:text-gray-100 focus:ring-2 focus:ring-[#54b5ff] focus:outline-none px-3 py-2 transition"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-slate-800 dark:text-gray-100">
                {{ __('profile.confirm_password') }}
            </label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-[#2c2c2e] border border-gray-300 dark:border-[#3a3a3c] text-slate-800 dark:text-gray-100 focus:ring-2 focus:ring-[#54b5ff] focus:outline-none px-3 py-2 transition"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Button + status --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-[#54b5ff] hover:bg-[#3da5f5] text-white font-medium py-2 px-6 rounded-lg shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#54b5ff]"
            >
                {{ __('profile.save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600 dark:text-gray-400"
                >
                    {{ __('profile.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>
