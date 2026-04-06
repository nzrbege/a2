<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #000;
            line-height: 1.6;
            background: #fff;
            padding: 20mm 25mm 20mm 30mm;
        }

        /* KOP */
        .kop {
            text-align: center;
            padding-bottom: 8px;
            border-bottom: 3px double #000;
            margin-bottom: 8px;
        }

        .kop h1 {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1px;
        }

        .kop h2 {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1px;
        }

        .kop h3 {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* JUDUL */
        .judul {
            text-align: center;
            margin-bottom: 10px;
        }

        .judul h4 {
            font-size: 12px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* TOTAL */
        .total-box {
            border: 1px solid #000;
            padding: 5px 14px;
            margin-bottom: 8px;
        }

        .total-box table {
            width: 100%;
            margin: 0;
            border: none;
        }

        .total-box table td {
            border: none;
            padding: 2px 0;
            font-size: 11px;
        }

        .total-box .label {
            font-weight: bold;
            font-size: 11px;
        }

        .total-box .amount {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            font-weight: bold;
            text-align: right;
        }

        /* HIERARKI */
        .program-header {
            font-weight: bold;
            font-size: 11px;
            padding: 3px 0 2px 0;
            margin-top: 12px;
            border-bottom: 1.5px solid #000;
            page-break-after: avoid;
        }

        .kegiatan-header {
            font-weight: bold;
            font-size: 10.5px;
            padding: 3px 0 2px 14px;
            margin-top: 8px;
            page-break-after: avoid;
        }

        .subkegiatan-header {
            font-size: 10.5px;
            padding: 2px 0 2px 28px;
            margin-top: 5px;
            font-weight: bold;
            font-style: italic;
            page-break-after: avoid;
        }

        .rekening-header {
            font-size: 10px;
            padding: 2px 0 2px 42px;
            margin-top: 4px;
            page-break-after: avoid;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            margin-bottom: 12px;
            margin-left: 42px;
            width: calc(100% - 42px);
            font-size: 10px;
        }

        thead th {
            padding: 5px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            border-top: 1.5px solid #000;
            border-bottom: 1px solid #000;
        }

        thead th:last-child {
            text-align: right;
        }

        tbody td {
            padding: 3px 8px;
            border-bottom: 0.5px solid #ccc;
        }

        tfoot td {
            padding: 5px 8px;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1.5px solid #000;
        }

        .right {
            text-align: right;
        }

        .mono {
            font-family: 'Courier New', monospace;
            font-size: 10px;
        }

        /* Nomor halaman */
        .page-number {
            text-align: center;
            font-size: 9px;
            color: #555;
        }

        /* Tanda tangan */
        .ttd {
            margin-top: 40px;
            text-align: right;
            padding-right: 20px;
        }

        .ttd .kota-tanggal {
            font-size: 10.5px;
            margin-bottom: 60px;
        }

        .ttd .nama {
            font-size: 11px;
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd .nip {
            font-size: 10px;
        }
    </style>
</head>
<body>

{{-- KOP --}}
<div class="kop">
    <h1>PEMERINTAH KABUPATEN KLATEN</h1>
    <h2>DINAS KOMUNIKASI DAN INFORMATIKA</h2>
    <h3>LAPORAN PENGELUARAN</h3>
</div>

{{-- JUDUL --}}
<div class="judul">
    @php
    $namaBulan = [
        1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MARET',
        4 => 'APRIL', 5 => 'MEI', 6 => 'JUNI',
        7 => 'JULI', 8 => 'AGUSTUS', 9 => 'SEPTEMBER',
        10 => 'OKTOBER', 11 => 'NOVEMBER', 12 => 'DESEMBER'
    ];
    @endphp
    <h4>BULAN {{ $namaBulan[(int)$bulan] }} {{ $tahun }}</h4>
</div>

{{-- TOTAL --}}
<div class="total-box">
    <table>
        <tr>
            <td class="label">Total Pengeluaran</td>
            <td class="amount mono">Rp {{ number_format($total,0,',','.') }}</td>
        </tr>
    </table>
</div>

{{-- DATA --}}
@foreach($grouped as $prog => $progRows)

    @php
        $namaProg = $progRows->first()->urai_prog ?? '-';
        $kegGroup = $progRows->groupBy('kd_keg');
    @endphp

    <div class="program-header">
        Program: {{ $prog }} &mdash; {{ $namaProg }}
    </div>

    @foreach($kegGroup as $keg => $kegRows)

        @php
            $namaKeg = $kegRows->first()->urai_keg ?? '-';
            $subGroup = $kegRows->groupBy('kd_subkeg');
        @endphp

        <div class="kegiatan-header">
            Kegiatan: {{ $keg }} &mdash; {{ $namaKeg }}
        </div>

        @foreach($subGroup as $sub => $subRows)

            @php
                $namaSub = $subRows->first()->urai_subkeg ?? '-';
                $rekGroup = $subRows->groupBy('kd_rek');
            @endphp

            <div class="subkegiatan-header">
                Sub Kegiatan: {{ $sub }} &mdash; {{ $namaSub }}
            </div>

            @foreach($rekGroup as $rek => $rekRows)

                @php
                    $namaRek = $rekRows->first()->urai_rekbel ?? '-';
                @endphp

                <div class="rekening-header">
                    Rekening: {{ $rek }} &mdash; {{ $namaRek }}
                </div>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 90px;">No</th>
                            <th style="width: 90px;">Tanggal</th>
                            <th>Uraian</th>
                            <th style="width: 130px;">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekRows as $i => $r)
                            <tr>
                                <td style="text-align: center;">{{ $i + 1 }}</td>
                                <td class="mono">{{ date('d-m-Y', strtotime($r->created_at)) }}</td>
                                <td>{{ $r->keperluan }}</td>
                                <td class="right mono">{{ number_format($r->nom_bruto,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="right">Jumlah</td>
                            <td class="right mono">{{ number_format($rekRows->sum('nom_bruto'),0,',','.') }}</td>
                        </tr>
                    </tfoot>
                </table>

            @endforeach

        @endforeach

    @endforeach

@endforeach

</body>
</html>
