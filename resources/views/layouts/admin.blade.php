<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <title>Admin - M3th</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/katex.min.css" />
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#18181a] dark:text-gray-100 transition-colors duration-300">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 sticky top-0 h-screen bg-white dark:bg-[#1c1c1e] border-r border-gray-200 dark:border-gray-700 shadow-sm z-20 flex flex-col justify-between">
            <nav class="p-4 space-y-3">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-white mb-6">
                    <i class="fas fa-crown mr-2 text-[#54b5ff]"></i> Admin Panel
                </h2>

                <a href="{{ route('admin.dashboard') }}"
                class="block @if(request()->routeIs('admin.dashboard')) text-[#54b5ff] font-semibold @endif hover:text-[#54b5ff] transition">
                    <i class="fas fa-chart-line mr-2"></i> {{ __('admin.dashboard') }}
                </a>

                <a href="{{ route('admin.questions.index') }}"
                class="block @if(request()->routeIs('admin.questions.*')) text-[#54b5ff] font-semibold @endif hover:text-[#54b5ff] transition">
                    <i class="fas fa-question-circle mr-2"></i> {{ __('admin.questions') }}
                </a>

                <a href="{{ route('admin.tests.index') }}"
                class="block @if(request()->routeIs('admin.tests.*')) text-[#54b5ff] font-semibold @endif hover:text-[#54b5ff] transition">
                    <i class="fas fa-flask mr-2"></i> {{ __('admin.tests') }}
                </a>

                <a href="{{ route('history.index') }}"
                class="block @if(request()->routeIs('history.index')) text-[#54b5ff] font-semibold @endif hover:text-[#54b5ff] transition">
                    <i class="fas fa-clock-rotate-left mr-2"></i> {{ __('admin.history') }}
                </a>
                
                <hr class="my-2 border-slate-300 dark:border-slate-600">

                <div class="mt-6">
                    <a href="{{ route('welcome') }}"
                    class="w-full flex items-center h-10 rounded-md overflow-hidden transition duration-300 group text-sm font-semibold">
                        <!-- Ikona -->
                        <div class="w-10 h-10 flex items-center justify-center bg-[#f7f7f7] dark:bg-[#1c1c1c] text-slate-800 dark:text-white transition-colors group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]">
                            <i class="fas fa-arrow-left"></i>
                        </div>

                        <!-- Textová časť s trojuholníkom -->
                        <div class="relative flex items-center h-full bg-[#e6f4ff] dark:bg-[#1e2b3a] text-[#1e3a5f] dark:text-[#9ec9ff] px-4 flex-grow rounded-r-md group-hover:bg-[#d5ecfd] dark:group-hover:bg-[#253448] transition-colors duration-300">
                            <span>{{ __('admin.back_to_site') }}</span>

                            <!-- Trojuholník -->
                            <div class="absolute -left-2 w-3.5 h-3.5 transform rotate-45 z-10 bg-[#f7f7f7] dark:bg-[#1c1c1c] group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121] transition-colors duration-300">
                            </div>
                        </div>
                    </a>
                </div>

            </nav>

            <div class="p-4 flex flex-col space-y-2 border-t border-gray-200 dark:border-gray-700">
                {{-- Actions --}}
                <div class="flex flex-col items-stretch space-y-2">
                    @auth
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="w-full flex items-center h-10 rounded-md overflow-hidden transition duration-300 group">
                                <div class="w-10 h-10 flex items-center justify-center bg-[#f7f7f7] dark:bg-[#1c1c1c] text-slate-800 dark:text-slate-100 group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="relative flex items-center justify-between flex-grow h-full px-4 bg-[#e6f4ff] dark:bg-[#1e2b3a] text-sm font-semibold text-[#1e3a5f] dark:text-[#9ec9ff] rounded-r-md group-hover:bg-[#d5ecfd] dark:group-hover:bg-[#253448]">
                                    <span>{{ Auth::user()->name }}</span>
                                    <div class="absolute -left-2 w-3.5 h-3.5 rotate-45 z-10 bg-[#f7f7f7] dark:bg-[#1c1c1c] group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]"></div>
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
                    @endauth

                    {{-- Theme Toggle --}}
                    <form method="POST" action="{{ route('theme.toggle') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center h-10 rounded-md overflow-hidden transition duration-300 group">
                            <div class="w-10 h-10 flex items-center justify-center bg-[#f7f7f7] dark:bg-[#1c1c1c] text-slate-800 dark:text-slate-100 group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]">
                                <i class="fas {{ session('theme') === 'dark' ? 'fa-sun' : 'fa-moon' }}"></i>
                            </div>
                            <div class="relative flex items-center justify-between flex-grow h-full px-4 bg-[#e6f4ff] dark:bg-[#1e2b3a] text-sm font-semibold text-[#1e3a5f] dark:text-[#9ec9ff] rounded-r-md group-hover:bg-[#d5ecfd] dark:group-hover:bg-[#253448]">
                                <span>{{ app()->getLocale() === 'sk' ? 'Téma' : 'Theme' }}</span>
                                <div class="absolute -left-2 w-3.5 h-3.5 rotate-45 z-10 bg-[#f7f7f7] dark:bg-[#1c1c1c] group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]"></div>
                            </div>
                        </button>
                    </form>

                    {{-- Language Toggle --}}
                    @php
                        $currentLang = app()->getLocale();
                        $newLang = $currentLang === 'sk' ? 'en' : 'sk';
                        $newUrl = url()->current();
                        $newUrl = strpos($newUrl, 'lang=') !== false
                            ? preg_replace('/([?&])lang=[^&]+/', '$1lang=' . $newLang, $newUrl)
                            : $newUrl . (parse_url($newUrl, PHP_URL_QUERY) ? '&' : '?') . 'lang=' . $newLang;
                    @endphp

                    <a href="{{ $newUrl }}" class="w-full flex items-center h-10 rounded-md overflow-hidden transition duration-300 group">
                        <div class="w-10 h-10 flex items-center justify-center bg-[#f7f7f7] dark:bg-[#1c1c1c] text-slate-800 dark:text-slate-100 group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]">
                            <i class="fas fa-language"></i>
                        </div>
                        <div class="relative flex items-center justify-between flex-grow h-full px-4 bg-[#e6f4ff] dark:bg-[#1e2b3a] text-sm font-semibold text-[#1e3a5f] dark:text-[#9ec9ff] rounded-r-md group-hover:bg-[#d5ecfd] dark:group-hover:bg-[#253448]">
                            <span>{{ strtoupper($newLang) }}</span>
                            <div class="absolute -left-2 w-3.5 h-3.5 rotate-45 z-10 bg-[#f7f7f7] dark:bg-[#1c1c1c] group-hover:bg-[#ebebeb] dark:group-hover:bg-[#212121]"></div>
                        </div>
                    </a>
                </div>
            </div>

        </aside>

        <!-- Main content -->
        <main class="flex-1 px-6 py-10">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>