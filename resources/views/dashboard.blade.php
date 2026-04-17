@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Keuangan</h1>
                <p class="text-sm text-gray-500 mt-1">Ringkasan realisasi anggaran</p>
            </div>
            <form method="GET" class="flex flex-wrap items-center gap-3">
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                    class="border-2 border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                <span class="text-gray-400 text-sm">s/d</span>
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                    class="border-2 border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm px-5 py-2 rounded-lg border-2 border-blue-500 hover:border-blue-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
            </form>
        </div>
    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-blue-300 transition-colors">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-50 border-2 border-blue-200 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Total</p>
            </div>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($total ?? 0,0,',','.') }}</p>
        </div>
        <div class="bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-amber-300 transition-colors">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-amber-50 border-2 border-amber-200 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Pending</p>
            </div>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($pending ?? 0,0,',','.') }}</p>
        </div>
        <div class="bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-emerald-300 transition-colors">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-emerald-50 border-2 border-emerald-200 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Disahkan</p>
            </div>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($disahkan ?? 0,0,',','.') }}</p>
        </div>
        <div class="bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-violet-300 transition-colors">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-violet-50 border-2 border-violet-200 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Jumlah Transaksi</p>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $jumlahTransaksi ?? 0 }}</p>
        </div>
    </div>

    {{-- CHART / RINGKASAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

        {{-- REKAP HIRARKI --}}
        <div class="lg:col-span-2 bg-white border-2 border-gray-200 rounded-xl p-5">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900">Realisasi per Program</h2>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="expandAll()" class="text-xs text-blue-500 hover:text-blue-700 font-medium px-2 py-1 rounded border border-blue-200 hover:bg-blue-50 transition-colors">Buka Semua</button>
                    <button onclick="collapseAll()" class="text-xs text-gray-500 hover:text-gray-700 font-medium px-2 py-1 rounded border border-gray-200 hover:bg-gray-50 transition-colors">Tutup Semua</button>
                </div>
            </div>

            <div class="space-y-3" id="hirarki-container">
                @foreach($hirarki as $progKode => $prog)

                {{-- ══════════════════════════════════════════
                     LEVEL 1 : PROGRAM
                ══════════════════════════════════════════ --}}
                <div class="border-2 border-blue-200 rounded-xl overflow-hidden">

                    <button type="button" onclick="toggleSection(this)"
                        class="w-full text-left px-4 py-3 bg-blue-50 hover:bg-blue-100 transition-colors">
                        <div class="flex items-start justify-between gap-3">
                            {{-- Kiri: badge + nama --}}
                            <div class="flex items-start gap-2 min-w-0">
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-500 rounded text-xs font-bold text-white shrink-0 mt-0.5">P</span>
                                <p class="text-sm font-semibold text-blue-900">{{ $progKode }} — {{ $prog['nama_prog'] }}</p>
                            </div>
                            {{-- Kanan: nominal + chevron --}}
                            <div class="flex items-center gap-3 shrink-0">
                                <div class="text-right hidden sm:block">
                                    <p class="text-xs text-blue-400 font-medium">Realisasi</p>
                                    <p class="text-sm font-bold text-blue-700">Rp {{ number_format($prog['realisasi'],0,',','.') }}</p>
                                </div>
                                <div class="text-right hidden sm:block">
                                    <p class="text-xs text-gray-400 font-medium">Pagu</p>
                                    <p class="text-sm font-semibold text-gray-600">Rp {{ number_format($prog['pagu'],0,',','.') }}</p>
                                </div>
                                <div class="flex flex-col items-center gap-0.5 shrink-0">
                                    <span class="text-xs font-bold
                                        {{ $prog['persen'] >= 80 ? 'text-emerald-600' : ($prog['persen'] >= 50 ? 'text-blue-600' : ($prog['persen'] >= 25 ? 'text-amber-600' : 'text-red-500')) }}">
                                        {{ $prog['persen'] }}%
                                    </span>
                                    <svg class="chevron w-4 h-4 text-blue-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        {{-- Progress bar program --}}
                        <div class="mt-2 flex items-center gap-2">
                            <div class="flex-1 h-1.5 bg-blue-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500
                                    {{ $prog['persen'] >= 80 ? 'bg-emerald-500' : ($prog['persen'] >= 50 ? 'bg-blue-500' : ($prog['persen'] >= 25 ? 'bg-amber-500' : 'bg-red-400')) }}"
                                    style="width: {{ $prog['persen'] }}%">
                                </div>
                            </div>
                        </div>
                    </button>

                    {{-- Isi Program --}}
                    <div class="collapsible-content">
                        <div class="p-3 space-y-2">

                            @foreach($prog['kegiatan'] as $kegKode => $keg)

                            {{-- ══════════════════════════════════════════
                                 LEVEL 2 : KEGIATAN
                            ══════════════════════════════════════════ --}}
                            <div class="border-2 border-emerald-100 rounded-lg overflow-hidden">

                                <button type="button" onclick="toggleSection(this)"
                                    class="w-full text-left px-3 py-2.5 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-2 min-w-0">
                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-emerald-500 rounded text-xs font-bold text-white shrink-0 mt-0.5">K</span>
                                            <p class="text-sm font-medium text-emerald-900">{{ $kegKode }} — {{ $keg['nama_keg'] }}</p>
                                        </div>
                                        <div class="flex items-center gap-3 shrink-0">
                                            <div class="text-right hidden sm:block">
                                                <p class="text-xs text-emerald-400 font-medium">Realisasi</p>
                                                <p class="text-sm font-bold text-emerald-700">Rp {{ number_format($keg['realisasi'],0,',','.') }}</p>
                                            </div>
                                            <div class="text-right hidden sm:block">
                                                <p class="text-xs text-gray-400 font-medium">Pagu</p>
                                                <p class="text-sm font-semibold text-gray-600">Rp {{ number_format($keg['pagu'],0,',','.') }}</p>
                                            </div>
                                            <div class="flex flex-col items-center gap-0.5 shrink-0">
                                                <span class="text-xs font-bold
                                                    {{ $keg['persen'] >= 80 ? 'text-emerald-600' : ($keg['persen'] >= 50 ? 'text-blue-600' : ($keg['persen'] >= 25 ? 'text-amber-600' : 'text-red-500')) }}">
                                                    {{ $keg['persen'] }}%
                                                </span>
                                                <svg class="chevron w-4 h-4 text-emerald-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-1.5 flex items-center gap-2">
                                        <div class="flex-1 h-1.5 bg-emerald-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500
                                                {{ $keg['persen'] >= 80 ? 'bg-emerald-500' : ($keg['persen'] >= 50 ? 'bg-blue-500' : ($keg['persen'] >= 25 ? 'bg-amber-500' : 'bg-red-400')) }}"
                                                style="width: {{ $keg['persen'] }}%">
                                            </div>
                                        </div>
                                    </div>
                                </button>

                                {{-- Isi Kegiatan --}}
                                <div class="collapsible-content">
                                    <div class="p-2 space-y-2">

                                        @foreach($keg['subkeg'] as $sub)

                                        {{-- ══════════════════════════════════════════
                                             LEVEL 3 : SUB KEGIATAN
                                        ══════════════════════════════════════════ --}}
                                        <div class="bg-white border-2 border-gray-100 rounded-lg overflow-hidden">

                                            <button type="button" onclick="toggleSection(this)"
                                                class="w-full text-left px-3 py-2.5 hover:bg-gray-50 transition-colors">
                                                <div class="flex items-start justify-between gap-2">
                                                    <div class="flex items-start gap-2 min-w-0 flex-1">
                                                        <span class="inline-flex items-center justify-center w-5 h-5 bg-gray-200 rounded text-xs font-bold text-gray-600 shrink-0 mt-0.5">S</span>
                                                        <div class="min-w-0 flex-1">
                                                            <p class="text-xs font-semibold text-gray-800 mb-1.5">{{ $sub['kode'] }} — {{ $sub['nama'] }}</p>
                                                            {{-- Info pagu / realisasi / sisa --}}
                                                            <div class="flex flex-wrap gap-x-3 gap-y-0.5 text-xs text-gray-500 mb-1.5">
                                                                <span>Pagu: <strong class="text-gray-700">Rp {{ number_format($sub['pagu'],0,',','.') }}</strong></span>
                                                                <span>Realisasi: <strong class="text-blue-600">Rp {{ number_format($sub['realisasi'],0,',','.') }}</strong></span>
                                                                <span>Sisa: <strong class="text-emerald-600">Rp {{ number_format($sub['sisa'],0,',','.') }}</strong></span>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                                    <div class="h-full rounded-full transition-all duration-500
                                                                        {{ $sub['persen'] >= 80 ? 'bg-emerald-500' : ($sub['persen'] >= 50 ? 'bg-blue-500' : ($sub['persen'] >= 25 ? 'bg-amber-500' : 'bg-red-400')) }}"
                                                                        style="width: {{ $sub['persen'] }}%">
                                                                    </div>
                                                                </div>
                                                                <span class="text-xs font-bold text-gray-600 w-10 text-right shrink-0">{{ $sub['persen'] }}%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Chevron sub kegiatan (hanya jika ada rekening) --}}
                                                    @if($sub['rekening']->count() > 0)
                                                    <div class="flex items-center gap-1 shrink-0 mt-0.5">
                                                        <span class="text-xs text-gray-400">{{ $sub['rekening']->count() }} rek.</span>
                                                        <svg class="chevron w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </div>
                                                    @endif
                                                </div>
                                            </button>

                                            {{-- ══════════════════════════════════════════
                                                 LEVEL 4 : REKENING
                                            ══════════════════════════════════════════ --}}
                                            @if($sub['rekening']->count() > 0)
                                            <div class="collapsible-content">
                                                <div class="border-t-2 border-gray-100 bg-gray-50 px-3 py-2.5">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Rincian Rekening</p>
                                                        {{-- Total rekening untuk sub kegiatan ini --}}
                                                        <span class="text-xs font-bold text-gray-700 bg-white border border-gray-200 rounded px-2 py-0.5">
                                                            Total: Rp {{ number_format($sub['rekening']->sum('total'),0,',','.') }}
                                                        </span>
                                                    </div>
                                                    <div class="space-y-1">
                                                        @foreach($sub['rekening'] as $rek)
                                                        <div class="flex items-center justify-between bg-white border border-gray-200 rounded-lg px-3 py-2 hover:border-indigo-200 transition-colors">
                                                            <div class="flex items-center gap-2 min-w-0">
                                                                <span class="inline-flex items-center justify-center w-4 h-4 bg-indigo-100 rounded text-xs font-bold text-indigo-600 shrink-0">R</span>
                                                                <div class="min-w-0">
                                                                    <span class="text-xs font-mono font-semibold text-gray-700">{{ $rek->kd_rekbel }}</span>
                                                                    @if($rek->nama_rekbel)
                                                                    <span class="text-xs text-gray-400 ml-1.5">— {{ $rek->nama_rekbel }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <span class="text-xs font-bold text-gray-900 shrink-0 ml-2">Rp {{ number_format($rek->total,0,',','.') }}</span>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                        {{-- END SUB KEGIATAN --}}
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            {{-- END KEGIATAN --}}
                            @endforeach

                        </div>
                    </div>
                </div>
                {{-- END PROGRAM --}}
                @endforeach
            </div>
        </div>

        {{-- REKAP REKENING (sidebar) --}}
        <div class="bg-white border-2 border-gray-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>
                <h2 class="text-lg font-bold text-gray-900">Pengeluaran per Rekening</h2>
            </div>
            <div class="space-y-2">
                @forelse($rekapRekening as $r)
                <div class="bg-gray-50 border-2 border-gray-100 rounded-lg px-4 py-3 hover:border-emerald-200 transition-colors">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs font-mono font-semibold text-gray-700">{{ $r->kd_rekbel }}</p>
                            @if($r->nama_rekbel)
                            <p class="text-xs text-gray-500 mt-0.5 leading-tight">{{ $r->nama_rekbel }}</p>
                            @endif
                        </div>
                        <span class="text-sm font-bold text-gray-900 shrink-0">Rp {{ number_format($r->total,0,',','.') }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-sm text-gray-400">Tidak ada data</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- LIST DATA --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- TOP PENGELUARAN --}}
        <div class="bg-white border-2 border-gray-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1.5 h-6 bg-red-400 rounded-full"></div>
                <h2 class="text-lg font-bold text-gray-900">Top Pengeluaran</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-3 px-2 font-semibold text-gray-500 text-xs uppercase tracking-wider">Uraian</th>
                            <th class="text-right py-3 px-2 font-semibold text-gray-500 text-xs uppercase tracking-wider">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topPengeluaran as $t)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-2 text-gray-700">{{ $t->keperluan }}</td>
                            <td class="py-3 px-2 text-right font-semibold text-gray-900">Rp {{ number_format($t->nom_bruto,0,',','.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TRANSAKSI TERAKHIR --}}
        <div class="bg-white border-2 border-gray-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1.5 h-6 bg-violet-500 rounded-full"></div>
                <h2 class="text-lg font-bold text-gray-900">Transaksi Terakhir</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-3 px-2 font-semibold text-gray-500 text-xs uppercase tracking-wider">Tanggal</th>
                            <th class="text-left py-3 px-2 font-semibold text-gray-500 text-xs uppercase tracking-wider">Uraian</th>
                            <th class="text-right py-3 px-2 font-semibold text-gray-500 text-xs uppercase tracking-wider">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerakhir as $t)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-2 text-gray-500 whitespace-nowrap">{{ date('d-m-Y', strtotime($t->created_at)) }}</td>
                            <td class="py-3 px-2 text-gray-700">{{ $t->keperluan }}</td>
                            <td class="py-3 px-2 text-right font-semibold text-gray-900 whitespace-nowrap">Rp {{ number_format($t->nom_bruto,0,',','.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</div>

<style>
    .collapsible-content {
        display: none;
        animation: slideDown 0.2s ease-out;
    }
    .collapsible-content.open {
        display: block;
    }
    .chevron.rotated {
        transform: rotate(180deg);
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-4px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function toggleSection(btn) {
        const content = btn.nextElementSibling;
        const chevron = btn.querySelector('.chevron');
        if (!content || !content.classList.contains('collapsible-content')) return;
        content.classList.toggle('open');
        if (chevron) chevron.classList.toggle('rotated');
    }

    function expandAll() {
        document.querySelectorAll('#hirarki-container .collapsible-content').forEach(el => el.classList.add('open'));
        document.querySelectorAll('#hirarki-container .chevron').forEach(el => el.classList.add('rotated'));
    }

    function collapseAll() {
        document.querySelectorAll('#hirarki-container .collapsible-content').forEach(el => el.classList.remove('open'));
        document.querySelectorAll('#hirarki-container .chevron').forEach(el => el.classList.remove('rotated'));
    }
</script>
@endsection
