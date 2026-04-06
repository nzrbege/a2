<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 11px; 
            color: #000;
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }

        .kop {
            text-align: center;
            margin-bottom: 10px;
        }

        .kop h2, .kop h3 {
            margin: 0;
            padding: 0;
        }

        .line {
            border-top: 2px solid #000;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .section {
            background: #eaeaea;
            font-weight: bold;
            padding: 4px;
            margin-top: 8px;
        }

        .subsection {
            font-weight: bold;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background: #dcdcdc;
            text-align: center;
        }

        tfoot td {
            background: #f2f2f2;
            font-weight: bold;
        }

        .mt-5 {
            margin-top: 5px;
        }

    </style>
</head>
<body>

{{-- KOP --}}
<div class="kop">
    <h3>PEMERINTAH KABUPATEN KLATEN</h3>
    <h2>DINAS KOMUNIKASI DAN INFORMATIKA</h2>
    <div>LAPORAN PENGELUARAN</div>
</div>

<div class="line"></div>

{{-- JUDUL --}}
<div class="judul">
    @php
$namaBulan = [
    1 => 'JANUARI',
    2 => 'FEBRUARI',
    3 => 'MARET',
    4 => 'APRIL',
    5 => 'MEI',
    6 => 'JUNI',
    7 => 'JULI',
    8 => 'AGUSTUS',
    9 => 'SEPTEMBER',
    10 => 'OKTOBER',
    11 => 'NOVEMBER',
    12 => 'DESEMBER'
];
@endphp

BULAN {{ $namaBulan[(int)$bulan] }} {{ $tahun }}
</div>

{{-- TOTAL --}}
<div class="bold">
    Total Pengeluaran: Rp {{ number_format($total,0,',','.') }}
</div>

<br>

{{-- DATA --}}
@foreach($grouped as $prog => $progRows)

    @php
        $namaProg = $progRows->first()->urai_prog ?? '-';
        $kegGroup = $progRows->groupBy('kd_keg');
    @endphp

    <div class="section">
        Program: {{ $prog }} - {{ $namaProg }}
    </div>

    @foreach($kegGroup as $keg => $kegRows)

        @php
            $namaKeg = $kegRows->first()->urai_keg ?? '-';
            $subGroup = $kegRows->groupBy('kd_subkeg');
        @endphp

        <div class="subsection">
            Kegiatan: {{ $keg }} - {{ $namaKeg }}
        </div>

        @foreach($subGroup as $sub => $subRows)

            @php
                $namaSub = $subRows->first()->urai_subkeg ?? '-';
                $rekGroup = $subRows->groupBy('kd_rek');
            @endphp

            <div class="subsection">
                Sub Kegiatan: {{ $sub }} - {{ $namaSub }}
            </div>

            @foreach($rekGroup as $rek => $rekRows)

                @php
                    $namaRek = $rekRows->first()->urai_rekbel ?? '-';
                @endphp

                <div class="mt-5 bold">
                    Rekening: {{ $rek }} - {{ $namaRek }}
                </div>

                <table>
                    <thead>
                        <tr>
                            <th width="15%">Tanggal</th>
                            <th width="55%">Uraian</th>
                            <th width="30%">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekRows as $r)
                            <tr>
                                <td>{{ date('d-m-Y', strtotime($r->created_at)) }}</td>
                                <td>{{ $r->keperluan }}</td>
                                <td class="right">
                                    Rp {{ number_format($r->nom_bruto,0,',','.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="right">Total Rekening</td>
                            <td class="right">
                                Rp {{ number_format($rekRows->sum('nom_bruto'),0,',','.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>

            @endforeach

        @endforeach

    @endforeach

@endforeach

</body>
</html>