@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-white shadow rounded-lg p-5 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">
                Detail Register A2
            </h2>
            <p class="text-sm text-gray-500">
                Informasi detail transaksi
            </p>
        </div>
        <span class="px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-700">
            {{ $register->gen_no_reg }}
        </span>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- INFORMASI UMUM --}}
    <div class="bg-white shadow rounded-lg">
        <div class="border-b px-5 py-3 font-semibold text-gray-700">
            Informasi Umum
        </div>
        <div class="p-5 space-y-3 text-sm">

            @php
                $rows = [
                    'Tanggal' => \Carbon\Carbon::parse($register->tanggal)->format('d-m-Y'),
                    'Program' => $register->kd_prog.' – '.$register->urai_prog,
                    'Kegiatan' => $register->kd_keg.' – '.$register->urai_keg,
                    'Sub Kegiatan' => $register->kd_subkeg.' – '.$register->urai_subkeg,
                    'Rekening' => $register->kd_rekbel.' – '.$register->urai_rekbel,
                    'Penerima' => $register->penerima,
                    'Keperluan' => $register->keperluan,
                ];
            @endphp

            @foreach($rows as $label => $value)
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-gray-500">{{ $label }}</div>
                    <div class="col-span-2 text-gray-800 font-medium">
                        {{ $value }}
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    {{-- RINCIAN RIIL --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="border-b px-5 py-3 font-semibold text-gray-700">
            Rincian Riil
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-2 text-center">No</th>
                        <th class="px-4 py-2 text-left">ID Rinci</th>
                        <th class="px-4 py-2 text-center">Volume</th>
                        <th class="px-4 py-2 text-right">Harga</th>
                        <th class="px-4 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($register->detailBelanja as $i => $d)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-center">{{ $i + 1 }}</td>
                            <td class="px-4 py-2">{{ $d->id_rinci_sub_bl }}</td>
                            <td class="px-4 py-2 text-center">{{ $d->volume }}</td>
                            <td class="px-4 py-2 text-right">
                                Rp {{ number_format($d->harga_riil,0,',','.') }}
                            </td>
                            <td class="px-4 py-2 text-right font-semibold">
                                Rp {{ number_format($d->total,0,',','.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                Tidak ada rincian riil
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- RINGKASAN KEUANGAN --}}
    <div class="bg-white shadow rounded-lg">
        <div class="border-b px-5 py-3 font-semibold text-gray-700">
            Ringkasan Keuangan
        </div>
        <div class="p-5 flex justify-end">
            <div class="w-full md:w-1/3 space-y-2 text-sm">

                <div class="flex justify-between">
                    <span class="text-gray-500">Bruto</span>
                    <span class="font-medium">
                        Rp {{ number_format($register->nom_bruto,0,',','.') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Pajak</span>
                    <span class="font-medium">
                        Rp {{ number_format($register->t_pajak,0,',','.') }}
                    </span>
                </div>

                <div class="border-t pt-2 flex justify-between text-base">
                    <span class="font-semibold">Netto</span>
                    <span class="font-bold text-green-600">
                        Rp {{ number_format($register->nom_bruto - $register->t_pajak,0,',','.') }}
                    </span>
                </div>

            </div>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="bg-white shadow rounded-lg p-4 flex justify-between">
        <a href="{{ route('a2.create') }}"
           class="inline-flex items-center px-4 py-2 text-sm border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            ← Kembali
        </a>

        <a href="{{ route('a2.print', $register->id_reg) }}"
           target="_blank"
           class="inline-flex items-center px-4 py-2 text-sm rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
            Cetak
        </a>
    </div>

</div>
@endsection
