<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="text-xl font-semibold text-gray-900">
                <!-- Tvoj logo alebo názov stránky -->
                <a href="{{ route('welcome.' . app()->getLocale()) }}" class="hover:text-indigo-600">Math World</a>
            </div>

            <div class="flex space-x-4">
                <!-- Slovensky -->
                <a href="{{ url('/sk') }}"
                   class="px-4 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out
                          hover:bg-indigo-100 hover:text-indigo-700
                          {{ app()->getLocale() === 'sk' ? 'bg-indigo-200 text-indigo-900' : 'text-gray-700' }}">
                    <span class="hidden md:inline">Slovensky</span>
                    <span class="md:hidden">SK</span>
                </a>
                
                <!-- English -->
                <a href="{{ url('/en') }}"
                   class="px-4 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out
                          hover:bg-indigo-100 hover:text-indigo-700
                          {{ app()->getLocale() === 'en' ? 'bg-indigo-200 text-indigo-900' : 'text-gray-700' }}">
                    <span class="hidden md:inline">English</span>
                    <span class="md:hidden">EN</span>
                </a>
            </div>
        </div>
    </div>
</nav>
