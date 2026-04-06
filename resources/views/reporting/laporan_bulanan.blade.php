@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Laporan Bulanan</h1>
                <p class="text-slate-500 text-sm">Ringkasan pengeluaran berdasarkan program dan kegiatan</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto space-y-5">

        {{-- FILTER & EXPORT --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <form id="filterForm" method="GET" class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <select name="bulan" onchange="document.getElementById('filterForm').submit()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 pl-4 pr-10 py-2.5 rounded-lg text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer hover:bg-slate-100">
                            @foreach(range(1,12) as $b)
                                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                    {{ date('F', mktime(0,0,0,$b,1)) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="tahun" onchange="document.getElementById('filterForm').submit()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 pl-4 pr-10 py-2.5 rounded-lg text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer hover:bg-slate-100">
                            @foreach(range(date('Y')-5, date('Y')) as $t)
                                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </form>

                <a href="{{ route('reporting.bulanan.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                   class="inline-flex items-center gap-2 bg-rose-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-rose-700 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </a>
            </div>
        </div>

        {{-- TOTAL --}}
        <div class="bg-indigo-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-200 text-sm font-medium uppercase tracking-wider">Total Pengeluaran</p>
                    <p class="text-3xl sm:text-4xl font-bold mt-1 tracking-tight">Rp {{ number_format($total,0,',','.') }}</p>
                </div>
                <div class="w-14 h-14 bg-white/15 rounded-xl flex items-center justify-center">
                    <span style="font-size:24px;font-weight:bold;color:white;">Rp</span>
                </div>
            </div>
        </div>

        {{-- LOOP HIERARKI --}}
        @foreach($grouped as $prog => $progRows)

        @php
            $namaProg = $progRows->first()->urai_prog ?? '-';
            $kegGroup = $progRows->groupBy('kd_keg');
        @endphp

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            {{-- Program Header --}}
            <div class="bg-slate-800 px-6 py-4">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/10 text-white text-xs font-bold">P</span>
                    <div>
                        <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Program</p>
                        <h2 class="text-white font-semibold text-lg">{{ $prog }} — {{ $namaProg }}</h2>
                    </div>
                </div>
            </div>

            <div class="p-5 space-y-5">
                @foreach($kegGroup as $keg => $kegRows)

                @php
                    $namaKeg = $kegRows->first()->urai_keg ?? '-';
                    $subGroup = $kegRows->groupBy('kd_subkeg');
                @endphp

                <div class="border border-slate-200 rounded-lg overflow-hidden">
                    {{-- Kegiatan Header --}}
                    <div class="bg-indigo-50 px-5 py-3 border-b border-indigo-100">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-indigo-100 text-indigo-600 text-xs font-bold">K</span>
                            <div>
                                <p class="text-indigo-400 text-xs font-medium uppercase tracking-wider">Kegiatan</p>
                                <h3 class="text-slate-700 font-semibold">{{ $keg }} — {{ $namaKeg }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 space-y-4">
                        @foreach($subGroup as $sub => $subRows)

                        @php
                            $namaSub = $subRows->first()->urai_subkeg ?? '-';
                            $rekGroup = $subRows->groupBy('kd_rek');
                        @endphp

                        <div class="border border-slate-100 rounded-lg overflow-hidden">
                            {{-- Sub Kegiatan Header --}}
                            <div class="bg-slate-50 px-4 py-2.5 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded bg-blue-100 text-blue-600 text-xs font-bold">S</span>
                                    <div>
                                        <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Sub Kegiatan</p>
                                        <h4 class="text-slate-600 font-medium text-sm">{{ $sub }} — {{ $namaSub }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 space-y-3">
                                @foreach($rekGroup as $rek => $rekRows)

                                @php
                                    $namaRek = $rekRows->first()->urai_rekbel ?? '-';
                                @endphp

                                <div class="bg-white rounded-lg border border-slate-100 overflow-hidden">
                                    {{-- Rekening Header --}}
                                    <div class="px-4 py-2.5 border-b border-slate-100 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                        <p class="text-slate-500 text-xs font-medium">
                                            <span class="text-slate-400">Rekening:</span>
                                            <span class="text-slate-700 font-semibold">{{ $rek }}</span> — {{ $namaRek }}
                                        </p>
                                    </div>

                                    {{-- Table --}}
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead>
                                                <tr class="bg-slate-50">
                                                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-slate-500 uppercase tracking-wider w-36">Tanggal</th>
                                                    <th class="text-left px-4 py-2.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Uraian</th>
                                                    <th class="text-right px-4 py-2.5 text-xs font-semibold text-slate-500 uppercase tracking-wider w-44">Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100">
                                                @foreach($rekRows as $r)
                                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                                    <td class="px-4 py-2.5 text-slate-500 font-mono text-xs">
                                                        {{ date('d-m-Y', strtotime($r->created_at)) }}
                                                    </td>
                                                    <td class="px-4 py-2.5 text-slate-700">{{ $r->keperluan }}</td>
                                                    <td class="px-4 py-2.5 text-right text-slate-700 font-medium font-mono">
                                                        Rp {{ number_format($r->nom_bruto,0,',','.') }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="bg-slate-50">
                                                    <td colspan="2" class="text-right px-4 py-3 text-sm font-bold text-slate-600 uppercase tracking-wide">
                                                        Total
                                                    </td>
                                                    <td class="text-right px-4 py-3 text-sm font-bold text-indigo-600 font-mono">
                                                        Rp {{ number_format($rekRows->sum('nom_bruto'),0,',','.') }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>

                        @endforeach
                    </div>
                </div>

                @endforeach
            </div>
        </div>

@endforeach

    </div>
</div>

{{-- LOADING OVERLAY --}}
<div id="loadingOverlay" class="fixed inset-0 bg-white/70 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="flex flex-col items-center gap-4">
        <div class="w-12 h-12 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
        <p class="text-slate-600 font-medium text-sm">Memuat data...</p>
    </div>
</div>

<script>
    document.querySelectorAll('#filterForm select').forEach(function(el) {
        el.addEventListener('change', function() {
            var overlay = document.getElementById('loadingOverlay');
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        });
    });
</script>
@endsection
