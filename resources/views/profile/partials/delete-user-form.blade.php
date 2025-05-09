<section class="space-y-4">
    <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
        <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
        {{ __('profile.delete_title') }}
    </h3>

    <p class="text-slate-700 dark:text-gray-400">
        {{ __('profile.delete_description') }}
    </p>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200"
    >
        {{ __('profile.delete_button') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h4 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
                {{ __('profile.delete_confirm_title') }}
            </h4>

            <p class="mt-1 text-sm text-slate-600 dark:text-gray-400">
                {{ __('profile.delete_confirm_text') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" :value="__('profile.password')" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('profile.password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 font-medium py-2 px-4 rounded-lg transition-all duration-200"
                >
                    {{ __('profile.cancel') }}
                </button>

                <button
                    type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200"
                >
                    {{ __('profile.delete_button') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
