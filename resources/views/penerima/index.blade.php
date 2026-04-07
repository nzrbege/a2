@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 space-y-4">

    {{-- ── HEADER ── --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-600 text-white">
                    <i class="bi bi-people-fill text-sm"></i>
                </span>
                Data Penerima
            </h1>
            <p class="text-xs text-slate-400 mt-0.5 ml-10">Kelola data penerima pembayaran</p>
        </div>
        <a href="{{ route('penerima.create') }}"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition-all duration-150">
            <i class="bi bi-plus-lg"></i> Tambah Penerima
        </a>
    </div>

    {{-- ── ALERT SUCCESS ── --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="flex items-center justify-between gap-3 px-4 py-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
            <div class="flex items-center gap-2">
                <i class="bi bi-check-circle-fill text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 text-lg leading-none">&times;</button>
        </div>
    @endif

    {{-- ── FILTER BAR ── --}}
    <form method="GET" action="{{ route('penerima.index') }}"
        class="bg-white border border-slate-200 rounded-xl px-5 py-4 flex flex-wrap gap-3 items-end">

        <input type="hidden" name="sort"  value="{{ request('sort') }}">
        <input type="hidden" name="order" value="{{ request('order') }}">

        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                <i class="bi bi-search text-emerald-500"></i> Cari Global
            </label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama / NPWP / Bank / Rekening..."
                class="border border-slate-300 rounded-lg px-3 py-1.5 text-xs w-64 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-slate-500">Tampil per halaman</label>
            <select name="per_page"
                class="border border-slate-300 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition bg-white"
                onchange="this.form.submit()">
                @foreach([10, 25, 50, 100] as $n)
                    <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }} data</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition-all duration-150 flex items-center gap-1.5">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
            <a href="{{ route('penerima.index') }}"
                class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-lg transition-all duration-150 flex items-center gap-1.5">
                <i class="bi bi-x-circle"></i> Reset
            </a>
        </div>

        <div class="ml-auto flex items-center gap-1.5 self-center bg-emerald-50 border border-emerald-100 rounded-lg px-3 py-1.5">
            <i class="bi bi-database text-emerald-400 text-xs"></i>
            <span class="text-xs font-semibold text-emerald-600">{{ $penerimas->total() }}</span>
            <span class="text-xs text-emerald-400">data ditemukan</span>
        </div>
    </form>

    {{-- ── TABEL ── --}}
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs border-collapse">
                <thead>

                    {{-- Baris 1: judul kolom + sort --}}
                    @php
                        $cols = [
                            'penerima'       => ['label' => 'Nama',        'icon' => 'bi-person'],
                            'npwp'           => ['label' => 'NPWP',        'icon' => 'bi-card-text'],
                            'bankpenerima'   => ['label' => 'Bank',        'icon' => 'bi-bank'],
                            'norek_penerima' => ['label' => 'No Rekening', 'icon' => 'bi-credit-card'],
                            'alamat'         => ['label' => 'Alamat',      'icon' => 'bi-geo-alt'],
                        ];
                        $currentSort  = request('sort', 'penerima');
                        $currentOrder = request('order', 'asc');
                    @endphp

                    <tr class="text-left" style="background: linear-gradient(135deg, #065f46 0%, #047857 60%, #059669 100%);">
                        <th class="px-3 py-3 border-r border-emerald-800/40 w-10 text-center text-emerald-200 font-medium">#</th>

                        @foreach ($cols as $field => $meta)
                            @php
                                $nextOrder = $currentSort === $field && $currentOrder === 'asc' ? 'desc' : 'asc';
                                $isActive  = $currentSort === $field;
                                $sortIcon  = $isActive ? ($currentOrder === 'asc' ? 'bi-sort-up' : 'bi-sort-down') : 'bi-arrow-down-up';
                            @endphp
                            <th class="px-3 py-3 border-r border-emerald-800/40 whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => $field, 'order' => $nextOrder]) }}"
                                    class="inline-flex items-center gap-1.5 font-semibold transition-colors
                                        {{ $isActive ? 'text-yellow-300' : 'text-white/90 hover:text-yellow-200' }}">
                                    <i class="bi {{ $meta['icon'] }} text-xs opacity-70"></i>
                                    {{ $meta['label'] }}
                                    <i class="bi {{ $sortIcon }} text-xs {{ $isActive ? 'opacity-100' : 'opacity-40' }}"></i>
                                </a>
                            </th>
                        @endforeach

                        <th class="px-3 py-3 text-center text-white/90 font-semibold w-28">
                            <span class="inline-flex items-center gap-1"><i class="bi bi-gear text-xs opacity-70"></i> Aksi</span>
                        </th>
                    </tr>

                    {{-- Baris 2: search per kolom --}}
                    <form method="GET" action="{{ route('penerima.index') }}" id="col-search-form">
                        <input type="hidden" name="sort"     value="{{ request('sort') }}">
                        <input type="hidden" name="order"    value="{{ request('order') }}">
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                        <tr style="background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);">
                            <th class="px-1.5 py-1.5 border-r border-emerald-900/50"></th>
                            @foreach ([
                                'f_nama'   => ['placeholder' => '🔍 Nama...'],
                                'f_npwp'   => ['placeholder' => '🔍 NPWP...'],
                                'f_bank'   => ['placeholder' => '🔍 Bank...'],
                                'f_norek'  => ['placeholder' => '🔍 No Rek...'],
                                'f_alamat' => ['placeholder' => '🔍 Alamat...'],
                            ] as $fname => $fmeta)
                            <th class="px-1.5 py-1.5 border-r border-emerald-900/50">
                                <input type="text" name="{{ $fname }}" value="{{ request($fname) }}"
                                    placeholder="{{ $fmeta['placeholder'] }}"
                                    class="col-search-input w-full text-xs rounded-lg px-2 py-1.5 bg-emerald-950/60 text-white placeholder-emerald-300/50 border border-emerald-700/50 focus:outline-none focus:ring-2 focus:ring-yellow-400/70 focus:border-yellow-400/50 transition">
                            </th>
                            @endforeach
                            <th class="px-1.5 py-1.5 text-center">
                                <button type="submit"
                                    class="w-full px-2 py-1.5 bg-yellow-400 hover:bg-yellow-300 text-emerald-900 text-xs font-bold rounded-lg transition-all duration-150 flex items-center justify-center">
                                    <i class="bi bi-search text-xs"></i>
                                </button>
                            </th>
                        </tr>
                    </form>

                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($penerimas as $i => $item)
                    <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-slate-50/70' }} hover:bg-emerald-50/60 transition-colors duration-100 group">
                        <td class="px-3 py-2.5 text-center border-r border-slate-100 text-slate-400 font-medium tabular-nums">
                            {{ $penerimas->firstItem() + $i }}
                        </td>
                        <td class="px-3 py-2.5 border-r border-slate-100">
                            <span class="font-semibold text-slate-800">{{ $item->penerima }}</span>
                        </td>
                        <td class="px-3 py-2.5 border-r border-slate-100 text-slate-600 tabular-nums">
                            {{ $item->npwp ?? '-' }}
                        </td>
                        <td class="px-3 py-2.5 border-r border-slate-100">
                            <span class="inline-flex items-center gap-1 text-slate-700">
                                <i class="bi bi-bank text-emerald-500 text-xs"></i>
                                {{ $item->bankpenerima ?? '-' }}
                            </span>
                        </td>
                        <td class="px-3 py-2.5 border-r border-slate-100 text-slate-600 tabular-nums whitespace-nowrap">
                            {{ $item->norek_penerima ?? '-' }}
                        </td>
                        <td class="px-3 py-2.5 border-r border-slate-100 text-slate-500 max-w-xs">
                            <span class="line-clamp-2" title="{{ $item->alamat }}">{{ $item->alamat ?? '-' }}</span>
                        </td>
                        <td class="px-3 py-2.5">
                            <div class="flex justify-center items-center gap-1">
                                <a href="{{ route('penerima.edit', $item->id) }}" title="Edit"
                                    class="inline-flex items-center justify-center w-7 h-7 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-all duration-150 hover:scale-105">
                                    <i class="bi bi-pencil text-xs"></i>
                                </a>
                                <form action="{{ route('penerima.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="inline-flex items-center justify-center w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-150 hover:scale-105">
                                        <i class="bi bi-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <i class="bi bi-people text-3xl text-slate-300"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Data tidak ditemukan</p>
                                    <p class="text-xs mt-0.5">Coba ubah filter pencarian</p>
                                </div>
                                @if(request()->hasAny(['q','f_nama','f_npwp','f_bank','f_norek','f_alamat']))
                                    <a href="{{ route('penerima.index') }}"
                                        class="text-xs text-emerald-600 hover:text-emerald-800 hover:underline flex items-center gap-1">
                                        <i class="bi bi-x-circle"></i> Hapus semua filter
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── PAGINATION ── --}}
    <div class="flex items-center justify-between pt-1">
        <p class="text-xs text-slate-400 flex items-center gap-1.5">
            <i class="bi bi-list-ol text-slate-300"></i>
            Menampilkan
            <span class="font-semibold text-slate-600">{{ $penerimas->firstItem() ?? 0 }}–{{ $penerimas->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold text-slate-600">{{ $penerimas->total() }}</span>
            data
        </p>
        <div class="text-sm">
            {{ $penerimas->appends(request()->query())->links() }}
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const colSearchForm = document.getElementById('col-search-form');
    const colSearchInputs = colSearchForm.querySelectorAll('input.col-search-input');

    colSearchInputs.forEach(input => {
        // Submit saat blur — hanya jika fokus keluar dari form (bukan Tab ke input berikutnya)
        input.addEventListener('blur', e => {
            const goingTo = e.relatedTarget;
            const stayingInForm = goingTo && colSearchForm.contains(goingTo);
            if (!stayingInForm) {
                colSearchForm.submit();
            }
        });

        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                colSearchForm.submit();
            }
            if (e.key === 'Escape') {
                input.value = '';
                colSearchForm.submit();
            }
        });
    });
</script>
@endpush
