<nav class="bg-white dark:bg-[#1a1919] shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <div class="text-xl font-semibold text-slate-800 dark:text-white">
                <a href="{{ route('welcome.' . app()->getLocale()) }}"
                    class="hover:text-[#54b5ff] dark:hover:text-[#54b5ff] transition duration-300 flex items-center gap-2">
                    <i class="fa-solid fa-square-root-variable text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    M3th
                </a>
            </div>

            @auth
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
            @else
            <div class="flex items-center space-x-6">
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:underline">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:underline">
                    {{ __('Register') }}
                </a>
            </div>
            @endauth

            {{-- Navigation Links --}}
            <div class="flex items-center space-x-6 text-base font-semibold">
                <a href="{{ route('welcome.' . app()->getLocale()) }}"
                    class="pb-1 border-b-2 transition duration-300
                        @if(request()->routeIs('welcome.*'))
                            border-[#54b5ff] text-slate-800 dark:text-white
                        @else
                            border-transparent text-slate-700 dark:text-gray-300 hover:border-[#54b5ff]
                        @endif">
                    {{ app()->getLocale() === 'sk' ? 'Návod' : 'Guide' }}
                </a>
            </div>

            {{-- Actions --}}
            <div class="flex items-center space-x-2">

                {{-- Theme Toggle --}}
                <form method="POST" action="{{ route('theme.toggle') }}">
                    @csrf
                    <button type="submit"
                        class="w-12 h-10 flex items-center justify-center rounded-md bg-white text-slate-800 hover:bg-[#ebebeb] dark:bg-[#1a1919] dark:text-slate-100 dark:hover:bg-[#212020] transition duration-300
                        shadow-inner shadow-[#828282] dark:shadow-[#0a0a0a]">
                        <i class="fas {{ session('theme') === 'dark' ? 'fa-sun' : 'fa-moon' }}"></i>
                    </button>
                </form>

                {{-- Language Toggle --}}
                @php
                $currentLang = app()->getLocale();
                $toggleLang = $currentLang === 'sk' ? 'en' : 'sk';
                $toggleLabel = strtoupper($toggleLang);
                @endphp

                <a href="{{ url('/' . $toggleLang) }}"
                    class="w-20 h-10 flex items-center justify-center gap-2 rounded-md bg-white text-slate-800 hover:bg-[#ebebeb] dark:bg-[#1a1919] dark:text-slate-100 dark:hover:bg-[#212020] transition duration-300
                        shadow-inner shadow-[#828282] dark:shadow-[#0a0a0a]">
                    <i class="fas fa-language"></i>
                    {{ $toggleLabel }}
                </a>

            </div>
        </div>
    </div>
</nav>