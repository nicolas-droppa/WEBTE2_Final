<nav class="bg-white dark:bg-gray-800 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Left side: Logo + Auth -->
            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <div class="text-xl font-semibold text-gray-900 dark:text-white">
                    <a href="{{ route('welcome.' . app()->getLocale()) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                        Math World
                    </a>
                </div>

                <!-- Auth -->
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
            </div>

            <!-- Right side: Theme toggle + Language switch -->
            <div class="flex items-center space-x-4">
                <!-- Theme Toggle -->
                

                <!-- Language Switch -->
                <a href="{{ url('/sk') }}"
                   class="px-4 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out
                          hover:bg-indigo-100 hover:text-indigo-700
                          dark:hover:bg-gray-700 dark:hover:text-white
                          {{ app()->getLocale() === 'sk' ? 'bg-indigo-200 text-indigo-900 dark:bg-indigo-600 dark:text-white' : 'text-gray-700 dark:text-gray-300' }}">
                    <span class="hidden md:inline">Slovensky</span>
                    <span class="md:hidden">SK</span>
                </a>
                <a href="{{ url('/en') }}"
                   class="px-4 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out
                          hover:bg-indigo-100 hover:text-indigo-700
                          dark:hover:bg-gray-700 dark:hover:text-white
                          {{ app()->getLocale() === 'en' ? 'bg-indigo-200 text-indigo-900 dark:bg-indigo-600 dark:text-white' : 'text-gray-700 dark:text-gray-300' }}">
                    <span class="hidden md:inline">English</span>
                    <span class="md:hidden">EN</span>
                </a>
                <form method="POST" action="{{ route('theme.toggle') }}">
                    @csrf
                    <button type="submit" class="px-2 py-1 text-sm rounded bg-gray-100 dark:bg-gray-700 dark:text-white hover:bg-indigo-100 dark:hover:bg-gray-600">
                        {{ session('theme') === 'dark' ? '🌞 Svetlý režim' : '🌙 Tmavý režim' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
