@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
<div class="max-w-7xl mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Manajemen User</h1>
            <p class="text-sm text-gray-500 mt-0.5">Kelola akun pengguna sistem</p>
        </div>
        <a href="{{ route('users.create') }}"
            class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm px-4 py-2.5 rounded-lg border-2 border-blue-500 hover:border-blue-600 transition-colors shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah User
        </a>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
    <div class="flex items-start gap-3 bg-emerald-50 border-2 border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 mb-5 text-sm">
        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="bg-white border-2 border-gray-200 rounded-xl overflow-hidden">

        {{-- TABLE HEADER BAR --}}
        <div class="flex items-center justify-between px-5 py-4 border-b-2 border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-5 bg-blue-500 rounded-full"></div>
                <p class="text-sm font-semibold text-gray-700">
                    Daftar User
                    <span class="ml-1.5 text-xs font-medium text-gray-400 bg-gray-100 rounded-full px-2 py-0.5">
                        {{ $users->total() }}
                    </span>
                </p>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b-2 border-gray-100">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">#</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Username</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Email</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">OPD</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Unit / Bidang</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Role</th>
                        <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $i => $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-400 text-xs">
                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                        </td>

                        {{-- Nama + avatar initial --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 border-2 border-blue-200 flex items-center justify-center shrink-0">
                                    <span class="text-xs font-bold text-blue-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <span class="font-medium text-gray-800 whitespace-nowrap">{{ $user->name }}</span>
                            </div>
                        </td>

                        <td class="px-5 py-3.5">
                            <span class="font-mono text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-md">{{ $user->username ?? '—' }}</span>
                        </td>

                        <td class="px-5 py-3.5 text-gray-600">{{ $user->email }}</td>

                        <td class="px-5 py-3.5 text-gray-600 max-w-[180px]">
                            <span class="block truncate" title="{{ $user->opd->nama_opd ?? '—' }}">
                                {{ $user->opd->nama_opd ?? '—' }}
                            </span>
                        </td>

                        <td class="px-5 py-3.5 text-gray-600 max-w-[160px]">
                            <span class="block truncate" title="{{ $user->unit->nama_unit ?? '—' }}">
                                {{ $user->unit->nama_unit ?? '—' }}
                            </span>
                        </td>

                        {{-- Role badge --}}
                        <td class="px-5 py-3.5">
                            @php
                                $roleClass = match($user->role) {
                                    'superadmin' => 'bg-violet-100 text-violet-700 border-violet-200',
                                    'admin'      => 'bg-blue-100 text-blue-700 border-blue-200',
                                    default      => 'bg-gray-100 text-gray-600 border-gray-200',
                                };
                                $roleLabel = match($user->role) {
                                    'superadmin' => 'Super Admin',
                                    'admin'      => 'Admin',
                                    default      => 'User',
                                };
                            @endphp
                            <span class="inline-flex items-center text-xs font-semibold px-2 py-0.5 rounded-full border {{ $roleClass }}">
                                {{ $roleLabel }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Edit --}}
                                <a href="{{ route('users.edit', $user) }}"
                                    class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-2.5 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>

                                {{-- Reset Password --}}
                                <form action="{{ route('users.resetPassword', $user) }}" method="POST"
                                    onsubmit="return confirm('Reset password user ini?')">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 text-xs font-medium text-amber-600 hover:text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-200 px-2.5 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                        Reset
                                    </button>
                                </form>

                                {{-- Hapus --}}
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 text-xs font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 border border-red-200 px-2.5 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-12 text-center">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-sm text-gray-400 font-medium">Belum ada user terdaftar</p>
                            <a href="{{ route('users.create') }}" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Tambah user pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($users->hasPages())
        <div class="px-5 py-4 border-t-2 border-gray-100">
            {{ $users->links() }}
        </div>
        @endif

    </div>
</div>
</div>
@endsection
