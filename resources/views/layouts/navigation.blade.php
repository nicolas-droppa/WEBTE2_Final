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
                        border-transparent text-slate-700 dark:text-gray-300 hover:border-[#54b5ff] hover:text-[#54b5ff] dark:hover:border-[#78cfff] dark:hover:text-[#78cfff]
                    @endif">
                    {{ app()->getLocale() === 'sk' ? 'Návod' : 'Guide' }}
                </a>

                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-slate-800 dark:text-gray-100 bg-transparent border-2 border-transparent dark:border-[#1a1919] hover:text-[#54b5ff] hover:border-[#78cfff] dark:hover:border-[#78cfff] dark:hover:text-[#78cfff] transition duration-200 ease-in-out">
                            <div class="font-semibold">{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4 text-slate-800 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-sm font-medium text-slate-800 dark:text-gray-200 hover:bg-[#54b5ff] hover:text-[#78cfff] dark:hover:bg-[#333] dark:hover:text-[#78cfff] transition-all duration-200">
                            {{ app()->getLocale() === 'sk' ? 'Profil' : 'Profile' }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-sm font-medium text-slate-800 dark:text-gray-200 hover:bg-[#54b5ff] hover:text-[#78cfff] dark:hover:text-[#78cfff] transition-all duration-200">
                                {{ app()->getLocale() === 'sk' ? 'Odhlásiť sa' : 'Log Out' }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                {{-- Login / Prihlásiť sa --}}
                <a href="{{ route('login', ['lang' => app()->getLocale()]) }}"
                class="pb-1 border-b-2 transition duration-300
                    @if(request()->routeIs('login'))
                        border-[#54b5ff] text-slate-800 dark:text-white
                    @else
                        border-transparent text-slate-700 dark:text-gray-300 hover:border-[#54b5ff] hover:text-[#54b5ff] dark:hover:text-[#78cfff]
                    @endif">
                    {{ app()->getLocale() === 'sk' ? 'Prihlásiť sa' : 'Login' }}
                </a>

                {{-- Register / Registrovať sa --}}
                <a href="{{ route('register') }}"
                class="pb-1 border-b-2 transition duration-300
                    @if(request()->routeIs('register'))
                        border-[#54b5ff] text-slate-800 dark:text-white
                    @else
                        border-transparent text-slate-700 dark:text-gray-300 hover:border-[#54b5ff] hover:text-[#54b5ff] dark:hover:text-[#78cfff]
                    @endif">
                    {{ app()->getLocale() === 'sk' ? 'Registrovať sa' : 'Register' }}
                </a>
                @endauth
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
