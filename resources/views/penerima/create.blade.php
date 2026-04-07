@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-2xl mx-auto px-4">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('penerima.index') }}"
               class="w-9 h-9 flex items-center justify-center rounded-lg border-2 border-gray-200 bg-white text-gray-400 hover:text-gray-700 hover:border-gray-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Tambah Penerima</h1>
                <p class="text-sm text-gray-400">Isi data penerima baru</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('penerima.store') }}" method="POST">
            @csrf

            <div class="bg-white border-2 border-gray-200 rounded-xl p-6 md:p-8">
                @include('penerima.form')
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('penerima.index') }}"
                   class="px-5 py-2.5 border-2 border-gray-200 text-gray-500 rounded-lg font-medium hover:border-gray-300 hover:text-gray-700 transition-colors bg-white text-sm">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-2.5 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600 transition-colors text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
