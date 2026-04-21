@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
<div class="max-w-2xl mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('users.index') }}"
            class="w-8 h-8 flex items-center justify-center rounded-lg border-2 border-gray-200 bg-white hover:bg-gray-50 hover:border-gray-300 transition-colors">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-9 h-9 rounded-lg bg-blue-100 border-2 border-blue-200 flex items-center justify-center shrink-0">
                <span class="text-sm font-bold text-blue-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
            <div class="min-w-0">
                <h1 class="text-xl font-bold text-gray-900 tracking-tight truncate">Edit: {{ $user->name }}</h1>
                <p class="text-xs text-gray-500 mt-0.5">Perbarui data akun pengguna</p>
            </div>
        </div>
    </div>

    {{-- VALIDATION ERRORS --}}
    @if($errors->any())
    <div class="bg-red-50 border-2 border-red-200 rounded-xl px-4 py-3 mb-5">
        <div class="flex items-start gap-2">
            <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <ul class="text-sm text-red-700 space-y-0.5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- FORM CARD --}}
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        <div class="bg-white border-2 border-gray-200 rounded-xl overflow-hidden">

            {{-- Section: Identitas --}}
            <div class="px-5 py-4 border-b-2 border-gray-100 bg-gray-50">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-blue-500 rounded-full"></div>
                    <p class="text-sm font-semibold text-gray-700">Identitas</p>
                </div>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Nama Lengkap --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Nama Lengkap <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Nama lengkap pengguna"
                        class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors @error('name') border-red-300 bg-red-50 @enderror">
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Username <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" placeholder="username"
                        class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:border-blue-400 transition-colors @error('username') border-red-300 bg-red-50 @enderror">
                    @error('username') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Email <span class="text-red-400">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="email@domain.com"
                        class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors @error('email') border-red-300 bg-red-50 @enderror">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Section: Akses & Unit --}}
            <div class="px-5 py-4 border-t-2 border-b-2 border-gray-100 bg-gray-50">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-violet-500 rounded-full"></div>
                    <p class="text-sm font-semibold text-gray-700">Akses & Unit Kerja</p>
                </div>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Role --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Role <span class="text-red-400">*</span>
                    </label>
                    <select name="role"
                        class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors bg-white @error('role') border-red-300 bg-red-50 @enderror">
                        <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin"      {{ old('role', $user->role) === 'admin'      ? 'selected' : '' }}>Admin</option>
                        <option value="user"       {{ old('role', $user->role) === 'user'       ? 'selected' : '' }}>User</option>
                    </select>
                    @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- OPD --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">OPD</label>
                    <select name="id_opd"
                        class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors bg-white @error('id_opd') border-red-300 bg-red-50 @enderror">
                        <option value="">-- Pilih OPD --</option>
                        @foreach($opds as $opd)
                        <option value="{{ $opd->id_opd }}" {{ old('id_opd', $user->id_opd) == $opd->id_opd ? 'selected' : '' }}>
                            {{ $opd->nama_opd }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_opd') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Bidang / Unit --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Unit / Bidang</label>
                    <select name="unit_id"
                        class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors bg-white @error('unit_id') border-red-300 bg-red-50 @enderror">
                        <option value="">-- Pilih Unit / Bidang --</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('id', $user->unit_id) == $unit->id ? 'selected' : '' }}>
                            {{ $unit->nama_unit }}
                        </option>
                        @endforeach
                    </select>
                    @error('unit_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Section: Ganti Password (opsional) --}}
            <div class="px-5 py-4 border-t-2 border-b-2 border-gray-100 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-5 bg-amber-400 rounded-full"></div>
                        <p class="text-sm font-semibold text-gray-700">Ganti Password</p>
                    </div>
                    <span class="text-xs text-gray-400 italic">Kosongkan jika tidak ingin mengubah</span>
                </div>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password Baru</label>
                    <input type="password" name="password" placeholder="Min. 6 karakter"
                        class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors @error('password') border-red-300 bg-red-50 @enderror">
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                        class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>

            </div>

            {{-- FOOTER ACTIONS --}}
            <div class="px-5 py-4 border-t-2 border-gray-100 bg-gray-50 flex items-center justify-between gap-3">
                {{-- Kiri: Reset Password --}}
                <form action="{{ route('users.resetPassword', $user) }}" method="POST"
                    onsubmit="return confirm('Generate password acak untuk {{ addslashes($user->name) }}?')">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 text-xs font-medium text-amber-600 hover:text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200 px-3 py-2 rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Reset Password Acak
                    </button>
                </form>

                {{-- Kanan: Batal + Simpan --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('users.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg border-2 border-gray-200 bg-white hover:bg-gray-100 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm px-5 py-2 rounded-lg border-2 border-blue-500 hover:border-blue-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>
</div>
@endsection
