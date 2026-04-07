@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">

    {{-- HEADER --}}
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Keuangan</h1>
                <p class="text-sm text-gray-500 mt-1">Ringkasan realisasi anggaran</p>
            </div>

            {{-- FILTER --}}
            <form method="GET" class="flex flex-wrap items-center gap-3">
                <input type="date" name="tanggal_mulai"
                    value="{{ request('tanggal_mulai') }}"
                    class="border-2 border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                <span class="text-gray-400 text-sm">s/d</span>

                <input type="date" name="tanggal_selesai"
                    value="{{ request('tanggal_selesai') }}"
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

        {{-- Total --}}
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

        {{-- Pending --}}
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

        {{-- Disahkan --}}
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

        {{-- Jumlah Transaksi --}}
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

        {{-- REKAP SUB KEGIATAN --}}
        <div class="lg:col-span-2 bg-white border-2 border-gray-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1.5 h-6 bg-blue-500 rounded-full"></div>
                <h2 class="text-lg font-bold text-gray-900">Realisasi per Program</h2>
            </div>

            <div class="space-y-5 max-h-[600px] overflow-y-auto pr-1">
                @foreach($hirarki as $progKode => $prog)
                <div class="border-2 border-gray-100 rounded-lg p-4">

                    {{-- PROGRAM --}}
                    <div class="flex items-start gap-2 mb-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-50 border border-blue-200 rounded text-xs font-bold text-blue-600 mt-0.5 shrink-0">P</span>
                        <p class="text-sm font-semibold text-gray-800">{{ $progKode }} - {{ $prog['nama_prog'] }}</p>
                    </div>

                    @foreach($prog['kegiatan'] as $kegKode => $keg)

                        {{-- KEGIATAN --}}
                        <div class="ml-4 mb-3">
                            <div class="flex items-start gap-2 mb-2">
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-emerald-50 border border-emerald-200 rounded text-xs font-bold text-emerald-600 mt-0.5 shrink-0">K</span>
                                <p class="text-sm font-medium text-gray-700">{{ $kegKode }} - {{ $keg['nama_keg'] }}</p>
                            </div>

                            {{-- SUB KEGIATAN --}}
                            <div class="ml-4 space-y-3">
                                @foreach($keg['subkeg'] as $sub)
                                <div class="bg-gray-50 border-2 border-gray-100 rounded-lg p-3">
                                    <p class="text-sm font-medium text-gray-800 mb-2">{{ $sub['kode'] }} - {{ $sub['nama'] }}</p>

                                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500 mb-3">
                                        <span>Pagu: <strong class="text-gray-700">Rp {{ number_format($sub['pagu'],0,',','.') }}</strong></span>
                                        <span>Realisasi: <strong class="text-blue-600">Rp {{ number_format($sub['realisasi'],0,',','.') }}</strong></span>
                                        <span>Sisa: <strong class="text-emerald-600">Rp {{ number_format($sub['sisa'],0,',','.') }}</strong></span>
                                    </div>

                                    {{-- PROGRESS BAR --}}
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500
                                                {{ $sub['persen'] >= 80 ? 'bg-emerald-500' : ($sub['persen'] >= 50 ? 'bg-blue-500' : ($sub['persen'] >= 25 ? 'bg-amber-500' : 'bg-red-400')) }}"
                                                style="width: {{ $sub['persen'] }}%">
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-600 w-10 text-right">{{ $sub['persen'] }}%</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

        {{-- REKAP REKENING --}}
        <div class="bg-white border-2 border-gray-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>
                <h2 class="text-lg font-bold text-gray-900">Pengeluaran per Rekening</h2>
            </div>

            <div class="space-y-2">
                @forelse($rekapRekening as $r)
                <div class="flex items-center justify-between bg-gray-50 border-2 border-gray-100 rounded-lg px-4 py-3 hover:border-emerald-200 transition-colors">
                    <span class="text-sm font-medium text-gray-700">{{ $r->kd_rekbel }}</span>
                    <span class="text-sm font-bold text-gray-900">Rp {{ number_format($r->total,0,',','.') }}</span>
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
                        <tr>
                            <td colspan="2" class="text-center py-8 text-gray-400">Tidak ada data</td>
                        </tr>
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
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-400">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
