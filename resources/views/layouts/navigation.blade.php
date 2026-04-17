<nav x-data="{ open: false, laporan: false, register: false, penerima: false }"
     class="sticky top-0 z-50 border-b transition-colors duration-300
            bg-white border-slate-200 shadow-sm
            dark:bg-slate-900 dark:border-slate-700/60">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14">

            {{-- LEFT: Logo + Nav --}}
            <div class="flex items-center gap-1">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-2 mr-3 group">
                    <div class="w-7 h-7 rounded-lg bg-blue-600 dark:bg-blue-500 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-bold text-base tracking-tight hidden sm:block text-slate-800 dark:text-white">
                        A<span class="text-blue-600 dark:text-cyan-400">2</span>
                    </span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden sm:flex sm:items-center gap-0.5">

                    {{-- Laporan Dropdown --}}
                    <div class="relative" @mouseenter="laporan=true" @mouseleave="laporan=false">
                        <button class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                                       text-slate-600 hover:text-slate-900 hover:bg-slate-100
                                       dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">
                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Laporan
                            <svg class="w-3 h-3 transition-transform duration-150 text-slate-400" :class="laporan ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="laporan"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute top-full left-0 mt-1 w-52 rounded-xl py-1 z-50 border
                                    bg-white border-slate-200 shadow-lg
                                    dark:bg-slate-800 dark:border-slate-700/60 dark:shadow-2xl dark:shadow-black/30">
                            <a href="{{ route('reporting.realisasi') }}"
                               class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm transition-colors
                                      text-slate-600 hover:text-slate-900 hover:bg-slate-50
                                      dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                </svg>
                                Realisasi Anggaran
                            </a>
                            <a href="{{ route('reporting.bulanan') }}"
                               class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm transition-colors
                                      text-slate-600 hover:text-slate-900 hover:bg-slate-50
                                      dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Laporan Bulanan
                            </a>
                        </div>
                    </div>

                    {{-- Register Dropdown --}}
                    <div class="relative" @mouseenter="register=true" @mouseleave="register=false">
                        <button class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                                       text-slate-600 hover:text-slate-900 hover:bg-slate-100
                                       dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">
                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Register
                            <svg class="w-3 h-3 transition-transform duration-150 text-slate-400" :class="register ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="register"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute top-full left-0 mt-1 w-48 rounded-xl py-1 z-50 border
                                    bg-white border-slate-200 shadow-lg
                                    dark:bg-slate-800 dark:border-slate-700/60 dark:shadow-2xl dark:shadow-black/30">
                            <a href="{{ route('a2.index') }}"
                               class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm transition-colors
                                      text-slate-600 hover:text-slate-900 hover:bg-slate-50
                                      dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                Daftar Register
                            </a>
                            <a href="{{ route('a2.create') }}"
                               class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm transition-colors
                                      text-slate-600 hover:text-slate-900 hover:bg-slate-50
                                      dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Register
                            </a>
                        </div>
                    </div>

                    {{-- Penerima Dropdown --}}
                    <div class="relative" @mouseenter="penerima=true" @mouseleave="penerima=false">
                        <button class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                                       text-slate-600 hover:text-slate-900 hover:bg-slate-100
                                       dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">
                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Penerima
                            <svg class="w-3 h-3 transition-transform duration-150 text-slate-400" :class="penerima ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="penerima"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute top-full left-0 mt-1 w-48 rounded-xl py-1 z-50 border
                                    bg-white border-slate-200 shadow-lg
                                    dark:bg-slate-800 dark:border-slate-700/60 dark:shadow-2xl dark:shadow-black/30">
                            <a href="{{ route('penerima.index') }}"
                               class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm transition-colors
                                      text-slate-600 hover:text-slate-900 hover:bg-slate-50
                                      dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                Daftar Penerima
                            </a>
                            <a href="{{ route('penerima.create') }}"
                               class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm transition-colors
                                      text-slate-600 hover:text-slate-900 hover:bg-slate-50
                                      dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50">
                                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Penerima
                            </a>
                        </div>
                    </div>

                    @if(Auth::user()->role === 'superadmin')
                        {{-- User Management --}}
                        <div class="relative">
                            <a href="{{ route('users.index') }}"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium transition-all duration-150
                                    text-slate-600 hover:text-slate-900 hover:bg-slate-100
                                    dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">

                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A7 7 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>

                                User
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            {{-- RIGHT: Theme Toggle + User --}}
            <div class="hidden sm:flex sm:items-center gap-2">

                {{-- Theme Toggle --}}
                {{-- <button x-data @click="$store.theme.toggle()"
                    class="w-8 h-8 rounded-lg flex items-center justify-center border transition-all duration-200
                           bg-slate-50 border-slate-200 text-slate-500 hover:text-slate-800 hover:border-slate-300
                           dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:text-white dark:hover:border-slate-500"
                    title="Toggle theme">
                    <svg x-show="!$store.theme.dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                    <svg x-show="$store.theme.dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"/><path stroke-linecap="round" d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                    </svg>
                </button> --}}

                {{-- User Dropdown --}}
                <div x-data="{ userMenu: false }" class="relative" @mouseenter="userMenu=true" @mouseleave="userMenu=false">
                    <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium border transition-all duration-150
                                   bg-slate-50 border-slate-200 text-slate-700 hover:border-slate-300
                                   dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:border-slate-500">
                        <div class="w-6 h-6 rounded-full bg-blue-600 dark:bg-blue-500 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="max-w-32 truncate">{{ Auth::user()->name }}</span>
                        <svg class="w-3 h-3 transition-transform duration-150 text-slate-400" :class="userMenu ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="userMenu"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute top-full right-0 mt-1 w-48 rounded-xl py-1 z-50 border
                                bg-white border-slate-200 shadow-lg
                                dark:bg-slate-800 dark:border-slate-700/60 dark:shadow-2xl dark:shadow-black/30">

                        {{-- User info --}}
                        <div class="px-3.5 py-2.5 border-b border-slate-100 dark:border-slate-700/60">
                            <p class="text-xs font-semibold text-slate-700 dark:text-slate-200 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 truncate">{{ Auth::user()->username ?? Auth::user()->email }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-2.5 px-3.5 py-2.5 text-sm transition-colors
                                  text-slate-600 hover:text-slate-900 hover:bg-slate-50
                                  dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile
                        </a>

                        <div class="border-t border-slate-100 dark:border-slate-700/60 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2.5 w-full px-3.5 py-2.5 text-sm text-left transition-colors
                                           text-red-500 hover:text-red-600 hover:bg-red-50
                                           dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-red-500/10">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile Hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md transition duration-150
                           text-slate-400 hover:text-slate-600 hover:bg-slate-100
                           dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t transition-colors
         border-slate-100 dark:border-slate-700/60">
        <div class="px-4 pt-3 pb-2 space-y-0.5">

            <p class="px-3 py-1 text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Laporan</p>
            <a href="{{ route('reporting.realisasi') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">Realisasi Anggaran</a>
            <a href="{{ route('reporting.bulanan') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">Laporan Bulanan</a>

            <p class="px-3 pt-3 py-1 text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Register</p>
            <a href="{{ route('a2.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">Daftar Register</a>
            <a href="{{ route('a2.create') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">Tambah Register</a>

            <p class="px-3 pt-3 py-1 text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Penerima</p>
            <a href="{{ route('penerima.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">Daftar Penerima</a>
            <a href="{{ route('penerima.create') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">Tambah Penerima</a>

            <p class="px-3 pt-3 py-1 text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">User</p>

            <a href="{{ route('users.index') }}"
            class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
                    text-slate-600 hover:text-slate-900 hover:bg-slate-100
                    dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">
                User Management
            </a>
        </div>

        {{-- Mobile User Section --}}
        <div class="pt-3 pb-3 border-t transition-colors border-slate-100 dark:border-slate-700/60">
            <div class="flex items-center gap-3 px-4 mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-600 dark:bg-blue-500 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-500">{{ Auth::user()->username ?? Auth::user()->email }}</p>
                </div>
            </div>

            <div class="px-4 space-y-0.5">
                {{-- Theme toggle mobile --}}
                {{-- <button x-data @click="$store.theme.toggle()"
                    class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-sm transition-colors
                           text-slate-600 hover:text-slate-900 hover:bg-slate-100
                           dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">
                    <svg x-show="!$store.theme.dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                    <svg x-show="$store.theme.dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"/><path stroke-linecap="round" d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                    </svg>
                    <span x-text="$store.theme.dark ? 'Light mode' : 'Dark mode'"></span>
                </button> --}}

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
                          text-slate-600 hover:text-slate-900 hover:bg-slate-100
                          dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-800">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-sm transition-colors
                               text-red-500 hover:text-red-600 hover:bg-red-50
                               dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-red-500/10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
