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

                @guest
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
                @endguest
            </div>


            {{-- Actions --}}
            <div class="flex items-center space-x-2">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center h-9 rounded-md overflow-hidden transition duration-300 group ml-auto">
                            <!-- Icon part -->
                            <div class="w-9 h-9 flex items-center justify-center bg-[#f7f7f7] dark:bg-[#1c1c1c] text-slate-800 dark:text-slate-100 transition-colors duration-300
                                group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]">
                                <i class="fas fa-user"></i>
                            </div>

                            <!-- Name + triangle -->
                            <div class="relative flex items-center h-full bg-[#e6f4ff] dark:bg-[#1e2b3a] text-[#1e3a5f] dark:text-[#9ec9ff] text-sm font-semibold pr-4 pl-5 rounded-r-md
                                transition-colors duration-300 group-hover:bg-[#d5ecfd] dark:group-hover:bg-[#253448]">
                                <span>{{ Auth::user()->name }}</span>
                                <div class="absolute -left-2 w-3.5 h-3.5 transform rotate-45 z-10
                                    bg-[#f7f7f7] dark:bg-[#1c1c1c] group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121] transition-colors duration-300">
                                </div>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @auth
                        @if(auth()->user()->isAdmin)
                        <x-dropdown-link
                            :href="route('admin.dashboard')"
                            class="text-sm font-medium text-slate-800 dark:text-gray-200 hover:bg-[#54b5ff] hover:text-[#78cfff] dark:hover:bg-[#333] dark:hover:text-[#78cfff] transition-all duration-200">
                            {{ __('Admin Panel') }}
                        </x-dropdown-link>
                        @endif
                        @endauth
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
                @endauth

                {{-- Theme Toggle --}}
                <form method="POST" action="{{ route('theme.toggle') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center h-9 rounded-md overflow-hidden transition duration-300 group">
                        <!-- Ikonová časť -->
                        <div class="w-9 h-9 flex items-center justify-center bg-[#f7f7f7] dark:bg-[#1c1c1c] text-slate-800 dark:text-slate-100 transition-colors duration-300
                            group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]">
                            <i class="fas {{ session('theme') === 'dark' ? 'fa-sun' : 'fa-moon' }}"></i>
                        </div>

                        <!-- Textová časť s trojuholníkom -->
                        <div class="relative flex items-center h-full bg-[#e6f4ff] dark:bg-[#1e2b3a] text-[#1e3a5f] dark:text-[#9ec9ff] text-sm font-semibold h-8 pl-4 pr-4 rounded-r-md
                            transition-colors duration-300 group-hover:bg-[#d5ecfd] dark:group-hover:bg-[#253448]">
                            <span>{{ app()->getLocale() === 'sk' ? 'Téma' : 'Theme' }}</span>

                            <!-- Trojuholník -->
                            <div class="absolute -left-2 w-3.5 h-3.5 transform rotate-45 z-10
                                bg-[#f7f7f7] dark:bg-[#1c1c1c] group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121] transition-colors duration-300">
                            </div>
                        </div>
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
                    class="flex items-center h-9 rounded-md overflow-hidden transition duration-300 group">
                    <!-- Ikonová časť -->
                    <div class="w-9 h-9 flex items-center justify-center bg-[#f7f7f7] dark:bg-[#1c1c1c] text-slate-800 dark:text-slate-100 transition-colors duration-300
                        group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]">
                        <i class="fas fa-language"></i>
                    </div>

                    <!-- Textová časť s trojuholníkom -->
                    <div class="relative flex items-center h-full bg-[#e6f4ff] dark:bg-[#1e2b3a] text-[#1e3a5f] dark:text-[#9ec9ff] text-sm font-semibold h-8 pl-4 pr-4 rounded-r-md
                        transition-colors duration-300 group-hover:bg-[#d5ecfd] dark:group-hover:bg-[#253448]">
                        <span>{{ strtoupper($newLang) }}</span>

                        <!-- Trojuholník -->
                        <div class="absolute -left-2 w-3.5 h-3.5 transform rotate-45 z-10
                            bg-[#f7f7f7] dark:bg-[#1c1c1c] group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121] transition-colors duration-300">
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</nav>