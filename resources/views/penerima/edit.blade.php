@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 py-10">
    <div class="max-w-2xl mx-auto px-4">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('penerima.index') }}"
               class="w-10 h-10 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:text-slate-700 dark:hover:text-slate-200 hover:border-emerald-300 dark:hover:border-emerald-600 hover:shadow-md transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-800 dark:text-white">Edit Penerima</h1>
                <p class="text-sm text-slate-400 dark:text-slate-500">Perbarui data penerima</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('penerima.update', $penerima->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden">
                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-800/80">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Edit Informasi Penerima</h2>
                            <p class="text-xs text-slate-400 dark:text-slate-500">Perbarui data yang diperlukan</p>
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
                        class="px-6 py-2.5 bg-emerald-500 text-white rounded-xl font-medium hover:bg-emerald-600 transition-all duration-200 text-sm flex items-center gap-2 shadow-lg shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Update
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
