<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 bg-slate-100 dark:bg-slate-900 transition-colors duration-300">

        <div class="w-full max-w-md">

            {{-- Theme Toggle --}}
            {{-- <div class="flex justify-end mb-4">
                <button
                    x-data
                    @click="$store.theme.toggle()"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium border transition-all duration-200
                           bg-white border-slate-200 text-slate-600 hover:border-slate-300
                           dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:border-slate-500"
                >
                    <svg x-show="!$store.theme.dark" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                    <svg x-show="$store.theme.dark" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"/><path stroke-linecap="round" d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                    </svg>
                    <span x-text="$store.theme.dark ? 'Light mode' : 'Dark mode'"></span>
                </button>
            </div> --}}

            {{-- Card --}}
            <div class="rounded-2xl p-8 border transition-colors duration-300
                        bg-white border-slate-200 shadow-sm
                        dark:bg-slate-800 dark:border-slate-700/60 dark:shadow-2xl dark:shadow-black/30">

                {{-- Logo --}}
                <div class="flex items-center gap-2.5 mb-8">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 dark:bg-blue-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-bold text-lg tracking-tight text-slate-800 dark:text-white">
                        A<span class="text-blue-600 dark:text-cyan-400">2</span>
                    </span>
                </div>

                <h1 class="text-2xl font-bold mb-1 text-slate-800 dark:text-white">Masuk ke Akun</h1>
                <p class="text-sm mb-7 text-slate-500 dark:text-slate-400">Sistem Informasi Anggaran</p>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="mb-5 px-4 py-3 rounded-lg text-sm
                                bg-blue-50 border border-blue-200 text-blue-700
                                dark:bg-cyan-500/10 dark:border-cyan-500/30 dark:text-cyan-400">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Username --}}
                    <div class="mb-5">
                        <label for="username" class="block text-xs font-semibold uppercase tracking-widest mb-2
                                                       text-slate-500 dark:text-slate-400">
                            Username
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none
                                         text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <input id="username" type="text" name="username" value="{{ old('username') }}"
                                placeholder="Masukkan username" required autofocus autocomplete="username"
                                class="w-full text-sm rounded-lg pl-10 pr-4 py-3 border outline-none transition duration-150
                                       bg-slate-50 border-slate-200 text-slate-800 placeholder-slate-400
                                       focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white
                                       dark:bg-slate-900/70 dark:border-slate-600/60 dark:text-white dark:placeholder-slate-600
                                       dark:focus:border-cyan-500 dark:focus:ring-cyan-500" />
                        </div>
                        @error('username')
                            <p class="mt-2 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-6">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-widest mb-2
                                                       text-slate-500 dark:text-slate-400">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none
                                         text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input id="password" type="password" name="password"
                                placeholder="••••••••" required autocomplete="current-password"
                                class="w-full text-sm rounded-lg pl-10 pr-4 py-3 border outline-none transition duration-150
                                       bg-slate-50 border-slate-200 text-slate-800 placeholder-slate-400
                                       focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:bg-white
                                       dark:bg-slate-900/70 dark:border-slate-600/60 dark:text-white dark:placeholder-slate-600
                                       dark:focus:border-cyan-500 dark:focus:ring-cyan-500" />
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center gap-2 mb-7">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-slate-300 bg-white text-blue-600
                                   dark:border-slate-600 dark:bg-slate-900 dark:text-cyan-500
                                   focus:ring-blue-500 dark:focus:ring-cyan-500 dark:focus:ring-offset-slate-800" />
                        <label for="remember_me" class="text-sm cursor-pointer select-none
                                                          text-slate-500 dark:text-slate-400">
                            Ingat saya
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full font-semibold text-sm py-3 rounded-lg transition-all duration-200
                               bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow-md
                               dark:bg-blue-600 dark:hover:bg-blue-500 dark:shadow-blue-500/20">
                        Masuk
                    </button>
                </form>

                <p class="mt-8 text-center text-xs text-slate-400 dark:text-slate-600">
                    &copy; {{ date('Y') }} A2. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
