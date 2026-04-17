@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="rounded-xl p-5 flex justify-between items-center border shadow-sm
                bg-white border-slate-200
                dark:bg-slate-800 dark:border-slate-700/60">
        <div>
            <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
                Detail Register A2
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Informasi detail transaksi
            </p>
        </div>
        <span class="px-3 py-1 rounded-full text-sm font-medium
                     bg-blue-100 text-blue-700
                     dark:bg-blue-500/20 dark:text-blue-300">
            {{ $register->gen_no_reg }}
        </span>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="px-4 py-3 rounded-xl text-sm font-medium border
                    bg-emerald-50 border-emerald-200 text-emerald-700
                    dark:bg-emerald-500/10 dark:border-emerald-500/30 dark:text-emerald-400">
            {{ session('success') }}
        </div>
    @endif

    {{-- INFORMASI UMUM --}}
    <div class="rounded-xl border shadow-sm overflow-hidden
                bg-white border-slate-200
                dark:bg-slate-800 dark:border-slate-700/60">
        <div class="px-5 py-3 font-semibold text-sm border-b
                    text-slate-700 border-slate-200
                    dark:text-slate-200 dark:border-slate-700/60">
            Informasi Umum
        </div>
        <div class="p-5 space-y-3 text-sm">
            @php
                $rows = [
                    'Tanggal'      => \Carbon\Carbon::parse($register->tanggal)->format('d-m-Y'),
                    'Program'      => $register->kd_prog.' – '.$register->urai_prog,
                    'Kegiatan'     => $register->kd_keg.' – '.$register->urai_keg,
                    'Sub Kegiatan' => $register->kd_subkeg.' – '.$register->urai_subkeg,
                    'Rekening'     => $register->kd_rekbel.' – '.$register->urai_rekbel,
                    'Penerima'     => $register->nama_penerima,
                    'Keperluan'    => $register->keperluan,
                ];
            @endphp

            @foreach($rows as $label => $value)
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-slate-500 dark:text-slate-400">{{ $label }}</div>
                    <div class="col-span-2 font-medium text-slate-800 dark:text-slate-100">{{ $value }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- RINCIAN RIIL --}}
    <div class="rounded-xl border shadow-sm overflow-hidden
                bg-white border-slate-200
                dark:bg-slate-800 dark:border-slate-700/60">
        <div class="px-5 py-3 font-semibold text-sm border-b
                    text-slate-700 border-slate-200
                    dark:text-slate-200 dark:border-slate-700/60">
            Rincian Riil
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-xs uppercase tracking-wide
                                bg-slate-50 text-slate-600 border-b border-slate-200
                                dark:bg-slate-700/50 dark:text-slate-400 dark:border-slate-700">
                        <th class="px-4 py-2.5 text-center">No</th>
                        <th class="px-4 py-2.5 text-left">ID Rinci</th>
                        <th class="px-4 py-2.5 text-left">Uraian Barang</th>
                        <th class="px-4 py-2.5 text-center">Volume</th>
                        <th class="px-4 py-2.5 text-right">Harga</th>
                        <th class="px-4 py-2.5 text-right">PPN</th>
                        <th class="px-4 py-2.5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse($register->detailBelanja as $i => $d)
                        <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/30">
                            <td class="px-4 py-2.5 text-center text-slate-500 dark:text-slate-400">{{ $i + 1 }}</td>
                            <td class="px-4 py-2.5 font-mono text-xs text-slate-600 dark:text-slate-300">{{ $d->id_rinci_sub_bl }}</td>
                            <td class="px-4 py-2.5 text-slate-700 dark:text-slate-200">{{ $d->rincianRka->nama_komponen }}</td>
                            <td class="px-4 py-2.5 text-center text-slate-700 dark:text-slate-200">{{ $d->volume }}</td>
                            <td class="px-4 py-2.5 text-right text-slate-700 dark:text-slate-200">
                                Rp {{ number_format($d->harga_riil,0,',','.') }}
                            </td>
                            <td class="px-4 py-2.5 text-right text-slate-700 dark:text-slate-200">
                                Rp {{ number_format($d->ppn,0,',','.') }}
                            </td>
                            <td class="px-4 py-2.5 text-right font-semibold text-slate-800 dark:text-white">
                                Rp {{ number_format($d->total_dibayar,0,',','.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400 dark:text-slate-500 italic">
                                Tidak ada rincian riil
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- RINGKASAN KEUANGAN --}}
    <div class="rounded-xl border shadow-sm overflow-hidden
                bg-white border-slate-200
                dark:bg-slate-800 dark:border-slate-700/60">
        <div class="px-5 py-3 font-semibold text-sm border-b
                    text-slate-700 border-slate-200
                    dark:text-slate-200 dark:border-slate-700/60">
            Ringkasan Keuangan
        </div>
        <div class="p-5 flex justify-end">
            <div class="w-full md:w-1/3 space-y-2 text-sm">

                <div class="flex justify-between pb-2 border-b border-slate-200 dark:border-slate-700">
                    <span class="font-semibold text-slate-500 dark:text-slate-400">Bruto</span>
                    <span class="font-medium text-slate-800 dark:text-slate-100">
                        Rp {{ number_format($register->nom_bruto,0,',','.') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500 dark:text-slate-400">Pajak</span>
                    <span class="font-medium text-slate-700 dark:text-slate-200">
                        Rp {{ number_format($register->t_pajak,0,',','.') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500 dark:text-slate-400">IWP (1%)</span>
                    <span class="font-medium text-slate-700 dark:text-slate-200">
                        Rp {{ number_format($register->t_iwp,0,',','.') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-red-500 dark:text-red-400">Total Potongan</span>
                    <span class="font-semibold text-red-500 dark:text-red-400">
                        Rp {{ number_format($register->t_potongan,0,',','.') }}
                    </span>
                </div>

                <div class="flex justify-between pt-2 border-t border-slate-200 dark:border-slate-700 text-base">
                    <span class="font-semibold text-slate-700 dark:text-slate-200">Netto</span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">
                        Rp {{ number_format($register->nom_netto,0,',','.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="rounded-xl border p-4 flex justify-between shadow-sm
                bg-white border-slate-200
                dark:bg-slate-800 dark:border-slate-700/60">
        <a href="{{ route('a2.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg border transition-colors
                  border-slate-300 text-slate-600 hover:bg-slate-50
                  dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700/50">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>

        <a href="{{ route('a2.print', $register->id_reg) }}" target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg transition-colors
                  bg-blue-600 hover:bg-blue-700 text-white shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak
        </a>
    </div>

</div>
@endsection
