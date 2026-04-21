@extends('layouts.app')

@section('header', 'Ubah Password')

@section('content')
<div class="max-w-lg mx-auto py-10 px-4 sm:px-6">

    {{-- Success Alert --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mb-6 rounded-xl border shadow-sm overflow-hidden
                    bg-emerald-50 border-emerald-200
                    dark:bg-emerald-900/20 dark:border-emerald-700/50">
            <div class="flex items-start gap-3 px-4 py-4">
                <div class="w-9 h-9 rounded-full bg-emerald-100 dark:bg-emerald-800/50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="flex-1 pt-0.5">
                    <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">Berhasil!</p>
                    <p class="text-sm text-emerald-700 dark:text-emerald-400 mt-0.5">{{ session('success') }}</p>
                </div>
                <button @click="show = false"
                        class="text-emerald-400 hover:text-emerald-600 dark:text-emerald-500 dark:hover:text-emerald-300 transition-colors mt-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="h-0.5 bg-emerald-200 dark:bg-emerald-700/50">
                <div class="h-full bg-emerald-500 dark:bg-emerald-400" style="animation: shrink 6s linear forwards;"></div>
            </div>
        </div>
    @endif

    @push('scripts')
    <style>
        @keyframes shrink { from { width: 100%; } to { width: 0%; } }
    </style>
    @endpush

    {{-- Card --}}
    <div class="rounded-2xl border shadow-sm transition-colors
                bg-white border-slate-200
                dark:bg-slate-800 dark:border-slate-700/60">

        {{-- Card Header --}}
        <div class="px-6 py-5 border-b transition-colors border-slate-100 dark:border-slate-700/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-600 dark:bg-blue-500 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Ubah Password</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pastikan menggunakan password yang kuat dan mudah diingat.</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('password.update') }}" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-5">

                {{-- Current Password --}}
                <div>
                    <label for="current_password" class="block text-sm font-medium mb-1.5
                                                          text-slate-700 dark:text-slate-300">
                        Password Saat Ini
                    </label>
                    <div class="relative">
                        <input :type="showCurrent ? 'text' : 'password'"
                               id="current_password"
                               name="current_password"
                               autocomplete="current-password"
                               class="w-full pr-10 px-3 py-2.5 rounded-lg text-sm border transition-colors
                                      bg-slate-50 border-slate-200 text-slate-800 placeholder-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                      dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200 dark:placeholder-slate-500
                                      @error('current_password') border-red-400 dark:border-red-500 focus:ring-red-500 @enderror"
                               placeholder="Masukkan password saat ini">
                        <button type="button" @click="showCurrent = !showCurrent"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <svg x-show="!showCurrent" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showCurrent" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="mt-1.5 text-xs text-red-500 dark:text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-100 dark:border-slate-700/60"></div>

                {{-- New Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium mb-1.5
                                                  text-slate-700 dark:text-slate-300">
                        Password Baru
                    </label>
                    <div class="relative">
                        <input :type="showNew ? 'text' : 'password'"
                               id="password"
                               name="password"
                               autocomplete="new-password"
                               class="w-full pr-10 px-3 py-2.5 rounded-lg text-sm border transition-colors
                                      bg-slate-50 border-slate-200 text-slate-800 placeholder-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                      dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200 dark:placeholder-slate-500
                                      @error('password') border-red-400 dark:border-red-500 focus:ring-red-500 @enderror"
                               placeholder="Minimal 8 karakter">
                        <button type="button" @click="showNew = !showNew"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <svg x-show="!showNew" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showNew" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500 dark:text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-1.5
                                                               text-slate-700 dark:text-slate-300">
                        Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'"
                               id="password_confirmation"
                               name="password_confirmation"
                               autocomplete="new-password"
                               class="w-full pr-10 px-3 py-2.5 rounded-lg text-sm border transition-colors
                                      bg-slate-50 border-slate-200 text-slate-800 placeholder-slate-400
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                      dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200 dark:placeholder-slate-500"
                               placeholder="Ulangi password baru">
                        <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showConfirm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            {{-- Card Footer --}}
            <div class="px-6 py-4 border-t rounded-b-2xl flex items-center justify-end gap-3 transition-colors
                        bg-slate-50 border-slate-100
                        dark:bg-slate-800/50 dark:border-slate-700/60">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                          text-slate-600 hover:text-slate-800 hover:bg-slate-200
                          dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-700">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-lg text-sm font-medium transition-all
                               bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white shadow-sm
                               dark:bg-blue-500 dark:hover:bg-blue-600">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
