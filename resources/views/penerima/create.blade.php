@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-10">
    <div class="max-w-2xl mx-auto px-4">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('penerima.index') }}"
               class="w-10 h-10 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-800 dark:text-white">Tambah Penerima</h1>
                <p class="text-sm text-slate-400 dark:text-slate-500">Isi data penerima baru</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('penerima.store') }}" method="POST">
            @csrf

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden">
                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-800/80">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Informasi Penerima</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-500">Lengkapi semua data di bawah ini</p>
                        </div>
                    </div>
                </div>

                {{-- Fields --}}
                <div class="p-6 md:p-8">
                    @include('penerima.form')
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('penerima.index') }}"
                   class="px-5 py-2.5 border-2 border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 rounded-xl font-medium hover:border-slate-300 dark:hover:border-slate-600 hover:text-slate-700 dark:hover:text-slate-200 transition-all duration-200 bg-white dark:bg-slate-800 text-sm">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-2.5 bg-blue-500 text-white rounded-xl font-medium hover:bg-blue-600 transition-all duration-200 text-sm flex items-center gap-2 shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
