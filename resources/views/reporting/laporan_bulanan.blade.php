@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4">

    <h1 class="text-xl font-bold mb-4">
        Laporan Bulanan
    </h1>
<div class="flex justify-between items-center mb-4">

    {{-- FILTER --}}
    <form method="GET" class="flex gap-2 mb-4">
        <select name="bulan" class="border px-2 py-1 rounded">
            @foreach(range(1,12) as $b)
                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                    {{ date('F', mktime(0,0,0,$b,1)) }}
                </option>
            @endforeach
        </select>

        <select name="tahun" class="border px-2 py-1 rounded">
            @foreach(range(date('Y')-5, date('Y')) as $t)
                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                    {{ $t }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white px-3 py-1 rounded">
            Tampilkan
        </button>
    </form>
     {{-- EXPORT --}}
    <a href="{{ route('reporting.bulanan.pdf', ['bulan'=>$bulan,'tahun'=>$tahun]) }}"
       class="bg-red-600 text-white px-3 py-1 rounded">
        Export PDF
    </a>

</div>

    {{-- TOTAL --}}
    <div class="bg-green-100 p-4 rounded mb-4">
        <b>Total Pengeluaran:</b>
        Rp {{ number_format($total,0,',','.') }}
    </div>

    {{-- LOOP HIERARKI --}}
    @foreach($grouped as $prog => $progRows)

    @php
        $namaProg = $progRows->first()->urai_prog ?? '-';
        $kegGroup = $progRows->groupBy('kd_keg');
    @endphp

    <div class="bg-indigo-100 p-2 font-bold">
        Program: {{ $prog }} - {{ $namaProg }}
    </div>

    @foreach($kegGroup as $keg => $kegRows)

        @php
            $namaKeg = $kegRows->first()->urai_keg ?? '-';
            $subGroup = $kegRows->groupBy('kd_subkeg');
        @endphp

        <div class="ml-4">
            <div class="bg-blue-100 p-2">
                Kegiatan: {{ $keg }} - {{ $namaKeg }}
            </div>

            @foreach($subGroup as $sub => $subRows)

                @php
                    $namaSub = $subRows->first()->urai_subkeg ?? '-';
                    $rekGroup = $subRows->groupBy('kd_rek');
                @endphp

                <div class="ml-6">
                    <div class="bg-yellow-100 p-2">
                        Sub Kegiatan: {{ $sub }} - {{ $namaSub }}
                    </div>

                    @foreach($rekGroup as $rek => $rekRows)

                        @php
                            $namaRek = $rekRows->first()->urai_rekbel ?? '-';
                        @endphp

                        <div class="ml-8 mb-3">

                            <div class="bg-gray-100 p-2">
                                Rekening: {{ $rek }} - {{ $namaRek }}
                            </div>

                            <table class="w-full text-sm border">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="p-2">Tanggal</th>
                                        <th class="p-2">Uraian</th>
                                        <th class="p-2 text-right">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekRows as $r)
                                        <tr>
                                            <td class="p-2">
                                                {{ date('d-m-Y', strtotime($r->created_at)) }}
                                            </td>
                                            <td class="p-2">{{ $r->keperluan }}</td>
                                            <td class="p-2 text-right">
                                                Rp {{ number_format($r->nom_bruto,0,',','.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr class="bg-gray-100 font-bold">
                                        <td colspan="2" class="text-right p-2">
                                            Total
                                        </td>
                                        <td class="text-right p-2">
                                            Rp {{ number_format($rekRows->sum('nom_bruto'),0,',','.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                    @endforeach

                </div>

            @endforeach

        </div>

    @endforeach

@endforeach

</div>
@endsection