<section class="space-y-4">
    <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100">
        <i class="fas fa-user mr-2 text-[#54b5ff]"></i>
        {{ __('profile.information_title') }}
    </h3>

    <p class="text-slate-700 dark:text-gray-400">
        {{ __('profile.information_description') }}
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6 mt-4">
        @csrf
        @method('patch')

        {{-- Name input --}}
        <div>
            <label for="name" class="block text-sm font-medium text-slate-800 dark:text-gray-100">
                {{ __('profile.name') }}
            </label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-[#2c2c2e] border border-gray-300 dark:border-[#3a3a3c] text-slate-800 dark:text-gray-100 focus:ring-2 focus:ring-[#54b5ff] focus:outline-none px-3 py-2 transition"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email input --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-800 dark:text-gray-100">
                {{ __('profile.email') }}
            </label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-[#2c2c2e] border border-gray-300 dark:border-[#3a3a3c] text-slate-800 dark:text-gray-100 focus:ring-2 focus:ring-[#54b5ff] focus:outline-none px-3 py-2 transition"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Email verification message --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-slate-700 dark:text-gray-400">
                    {{ __('profile.email_unverified') }}
                    <button form="send-verification" class="underline font-medium text-[#54b5ff] hover:text-[#3a99dd] dark:hover:text-[#78cfff]">
                        {{ __('profile.resend_verification') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-green-600 dark:text-green-400">
                            {{ __('profile.verification_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Save button --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-[#54b5ff] hover:bg-[#3da5f5] text-white font-medium py-2 px-6 rounded-lg shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#54b5ff]"
            >
                {{ __('profile.save') }}
            </button>

            @if (session('status') === 'profile-updated')
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
