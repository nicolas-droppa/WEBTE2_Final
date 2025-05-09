<nav class="bg-white dark:bg-[#1a1919] shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <div class="text-xl font-semibold text-slate-800 dark:text-white">
                <a href="{{ route('welcome') }}"
                   class="hover:text-[#54b5ff] dark:hover:text-[#54b5ff] transition duration-300 flex items-center gap-2">
                    <i class="fa-solid fa-square-root-variable text-[#54b5ff] dark:text-[#54b5ff]"></i>
                    M3th
                </a>
            </div>

            {{-- Navigation Links --}}
            <div class="flex items-center space-x-6 text-base font-semibold">
                {{-- Guide / Návod --}}
                <a href="{{ route('welcome') }}"
                   class="pb-1 border-b-2 transition duration-300
                       @if(request()->routeIs('welcome'))
                           border-[#54b5ff] text-slate-800 dark:text-white
                       @else
                           border-transparent text-slate-700 dark:text-gray-300 hover:border-[#54b5ff]
                       @endif">
                    {{ app()->getLocale() === 'sk' ? 'Návod' : 'Guide' }}
                </a>

                {{-- Login / Prihlásiť sa --}}
                <a href="{{ route('login', ['lang' => app()->getLocale()]) }}"
                class="pb-1 border-b-2 transition duration-300
                    @if(request()->routeIs('login'))
                        border-[#54b5ff] text-slate-800 dark:text-white
                    @else
                        border-transparent text-slate-700 dark:text-gray-300 hover:border-[#54b5ff]
                    @endif">
                    {{ app()->getLocale() === 'sk' ? 'Prihlásiť sa' : 'Login' }}
                </a>

                {{-- Register / Registrovať sa --}}
                <a href="{{ route('register') }}"
                   class="pb-1 border-b-2 transition duration-300
                       @if(request()->routeIs('register'))
                           border-[#54b5ff] text-slate-800 dark:text-white
                       @else
                           border-transparent text-slate-700 dark:text-gray-300 hover:border-[#54b5ff]
                       @endif">
                    {{ app()->getLocale() === 'sk' ? 'Registrovať sa' : 'Register' }}
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
    $newLang = $currentLang === 'sk' ? 'en' : 'sk';

    // Získaj aktuálnu URL
    $newUrl = url()->current();

    // Skontroluj, či URL obsahuje parameter lang
    if (strpos($newUrl, 'lang=') !== false) {
        // Ak už parameter lang existuje, prepíšeme ho
        $newUrl = preg_replace('/([?&])lang=[^&]+/', '$1lang=' . $newLang, $newUrl);
    } else {
        // Ak nie je, pridáme nový parameter lang
        $newUrl = $newUrl . (parse_url($newUrl, PHP_URL_QUERY) ? '&' : '?') . 'lang=' . $newLang;
    }
@endphp

<a href="{{ $newUrl }}"
   class="w-20 h-10 flex items-center justify-center gap-2 rounded-md bg-white text-slate-800 hover:bg-[#ebebeb] dark:bg-[#1a1919] dark:text-slate-100 dark:hover:bg-[#212020] transition duration-300 shadow-inner shadow-[#828282] dark:shadow-[#0a0a0a]">
    <i class="fas fa-language"></i>
    {{ strtoupper($newLang) }}
</a>

            </div>
        </div>
    </div>
</nav>
