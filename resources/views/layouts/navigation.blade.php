<nav class="bg-white dark:bg-gray-800 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('welcome.' . app()->getLocale()) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                    Math World
                </a>
            </div>

            <form method="POST" action="{{ route('theme.toggle') }}">
                @csrf
                <button type="submit" class="px-2 py-1 text-sm rounded bg-gray-100 dark:bg-gray-700 dark:text-white hover:bg-indigo-100 dark:hover:bg-gray-600">
                    {{ session('theme') === 'dark' ? '🌞 Svetlý režim' : '🌙 Tmavý režim' }}
                </button>
            </form>

            <div class="flex space-x-4">
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
            </div>
        </div>
    </div>
</nav>
