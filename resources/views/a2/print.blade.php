<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print Surat Bukti Pengeluaran</title>
    <style>
        @page {
            size: A4;
            margin: 0.5cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
            margin: 0;
            padding: 10px;
            color: #000;
        }

        /* Table Base Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        /* Layout Helpers */
        .no-border {
            border: none;
        }

        .no-border-bottom {
            border-bottom: none;
        }

        .no-border-top {
            border-top: none;
        }

        .no-border-right {
            border-right: none;
        }

        .no-border-left {
            border-left: none;
        }

        .bold {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .italic {
            font-style: italic;
        }

        /* Specific Header Sizing */
        .logo-col {
            width: 80px;
            text-align: center;
        }

        .form-label-col {
            width: 100px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            vertical-align: middle;
        }

        /* Signature Box height */
        .sig-box {
            height: 110px;
        }

        .name-underlined {
            text-decoration: underline;
            font-weight: bold;
            display: block;
            margin-top: 80px;
        }

        /* Verifikasi Table */
        .verif-table {
            width: 50%;
            float: right;
            margin-top: 10px;
        }

        .verif-table th {
            border: 1px solid #000;
            font-size: 8pt;
            background: #eee;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }

        .btn-print {
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
            border-radius: 4px;
        }
    .colon {
        width: 5px;
        white-space: nowrap;
        text-align: center;
        padding-left: 2px;
        padding-right: 2px;
    }

    .nowrap {
        white-space: nowrap;
    }
    </style>

    <script>
        window.onload = function () {
            window.print();

            // Tunggu dialog print selesai, lalu tutup tab
            window.onafterprint = function () {
                window.close();
            };
        }
    </script>
</head>

<body>
    <table>
        <tr>
            <td rowspan="3" colspan = "2" class="logo-col center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/LOGO_KABUPATEN_KLATEN.png" width="100%"
                    alt="Logo">
            </td>
            <td colspan="5" class="center bold no-border-bottom">PEMERINTAH KABUPATEN KLATEN<br>DINAS KOMUNIKASI DAN
                INFORMATIKA</td>
            <td rowspan="3" colspan ="2" class="form-label-col center">FORMULIR<br>KAS KELUAR</td>
        </tr>
        <tr>
            <td colspan="5" class="center bold border-bottom">SURAT BUKTI PENGELUARAN</td>
        </tr>
        <tr>
            <td colspan="5" class="no-border-right">
                <table class="no-border">
                    <tr class="no-border">
                        <td class="no-border" width="60">Nomor</td>
                        <td class="no-border" width="10">:</td>
                        <td class="no-border">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/BP/{{$register->jenis_tu}}-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/{{ $nomorsurat }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Tanggal</td>
                        <td class="no-border">:</td>
                        <td class="no-border"></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="9">
                <span class="bold">Unit Organisasi : {{ $register->kode_skpd }} - {{ $register->nama_skpd }}</span>
            </td>
        </tr>

        <tr>
            <td colspan="9">
                Sudah diterima dari Bendahara Pengeluaran Diskominfo Kab. Klaten, uang sejumlah <span>Rp {{ number_format($register->nom_netto, 2, ',', '.') }}</span>, secara {{ $register->j_transaksi }}
                <br>
                <span class="italic">Terbilang : {{ $register->netto_terbilang }}</span>
            </td>
        </tr>

        <tr>
            <td colspan="9" class="no-border-bottom">
                <span class="bold">Untuk Pembayaran</span>
                <table class="no-border">
                    <tr class="no-border">
                        <td class="no-border" width="110">Program</td>
                        <td class="no-border" width="10">:</td>
                        <td class="no-border bold">{{ $register->kd_prog }} {{ $register->urai_prog }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Kegiatan</td>
                        <td class="no-border">:</td>
                        <td class="no-border bold">{{ $register->kd_keg }} {{ $register->urai_keg }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Sub Kegiatan</td>
                        <td class="no-border">:</td>
                        <td class="no-border bold">{{ $register->kd_subkeg }} {{ $register->urai_subkeg }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Kode Rekening</td>
                        <td class="no-border">:</td>
                        <td class="no-border bold">{{ $register->kd_rekbel }} {{ $register->urai_rekbel }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Keperluan</td>
                        <td class="no-border">:</td>
                        <td class="no-border bold italic">{{ $register->keperluan }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="5" class="no-border-right">
                <span class="bold">Diterima Oleh :</span>
                <table class="no-border" style="margin-top: 5px;">
                    <tr class="no-border">
                        <td class="no-border" width="100">Nama</td>
                        <td class="no-border" width="10">:</td>
                        <td class="no-border bold">{{ $register->nama_penerima }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Bank</td>
                        <td class="no-border">:</td>
                        <td class="no-border">{{ $register->bank_penerima }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Rekening</td>
                        <td class="no-border">:</td>
                        <td class="no-border bold">{{ $register->norek_penerima }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">NPWP</td>
                        <td class="no-border">:</td>
                        <td class="no-border bold">{{ $register->npwp_penerima }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Alamat</td>
                        <td class="no-border">:</td>
                        <td class="no-border">{{ $register->alamat_penerima }}</td>
                    </tr>
                </table>
                <div class="center bold" style="margin-top: 40px;">{{ $register->nama_penerima }}</div>
            </td>
            <td colspan="4">
                <table width="100%" style="table-layout: fixed; border-collapse: collapse;">
                    <colgroup>
                        <col style="width:20%">  <!-- kolom 1 -->
                        <col style="width:43%">  <!-- kolom 2 -->
                        {{-- <col style="width:28%">  <!-- kolom 3 --> --}}
                        <col style="width:2%">   <!-- ":" -->
                        <col style="width:35%">  <!-- nominal -->
                    </colgroup>
                    <tr class="no-border">
                        <td colspan="2" class="no-border">Jumlah yang Diminta</td>
                        <td class="no-border right">:</td>
                        <td class="right bold no-border">Rp {{ number_format($register->nom_bruto, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="4" class="bold no-border" style="text-decoration: underline; padding-top: 10px;">
                            Informasi Potongan Pajak</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border nowrap" colspan="4">Penerimaan PPK-</td>
                    </tr>
                    <tr class="no-border">
                        {{-- <td class="no-border nowrap" rowspan="2">Penerimaan PPK-</td> --}}
                        <td class="no-border">{{ ($register->nom_pajak1 === null || $register->nom_pajak1 == 0)? '' : $register->jpajak_1 }}</td>
                        <td class="no-border">{{ (($register->nom_pajak1 !== null || $register->nom_pajak1 <> 0) && $register->jpajak_1 == 'PAD')? '' : ((($register->nom_pajak1 !== null || $register->nom_pajak1 <> 0) && $register->jpajak_1 !== null)?'Kode : '.$register->kd_pot1:'') }}</td>
                        <td class="no-border colon right">{{ ($register->nom_pajak1 === null || $register->nom_pajak1 == 0)? '' : ':' }}</td>
                        <td class="no-border right">{{ ($register->nom_pajak1 === null || $register->nom_pajak1 == 0)? '' : 'Rp '.number_format($register->nom_pajak1, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border nowrap">{{ ($register->nom_pajak2 === null || $register->nom_pajak2 == 0)? '' : $register->jpajak_2 }}</td>
                        <td class="no-border">{{ (($register->nom_pajak2 !== null || $register->nom_pajak2 == 0) && $register->jpajak_2 == 'PAD')? '' : ((($register->nom_pajak2 !== null || $register->nom_pajak2 <> 0) && $register->tpajak_2 !== null)?'Kode : '.$register->kd_pot2:'') }}</td>
                        <td class="no-border colon right">{{ ($register->nom_pajak2 === null || $register->nom_pajak2 == 0)? '' : ':' }}</td>
                        <td class="no-border right">{{ ($register->nom_pajak2 === null || $register->nom_pajak2 == 0)? '' : 'Rp '.number_format($register->nom_pajak2, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="4" class="left no-border" style="padding: 10px 0;">Pemungutan oleh Bendaharawan APBD
                        </td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="2" class="right no-border">Jumlah Potongan</td>
                        <td class="no-border right">:</td>
                        <td class="right bold no-border">Rp {{ number_format($register->t_pajak, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="2" style="padding-top: 10px;" class="no-border">Jumlah yang dibayarkan</td>
                        <td class="no-border right">:</td>
                        <td class="right bold no-border" style="padding-top: 10px;">Rp {{ number_format($register->nom_netto, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Terbilang :</td>
                        <td class="right bold italic no-border" colspan="3">{{ $register->netto_terbilang }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="center sig-box"><br>
                PENGGUNA ANGGARAN<br>DISKOMINFO KAB. KLATEN
                <span class="name-underlined">{{ $register->nama_pa }}</span>
                NIP {{ $register->nip_pa }}
            </td>
            <td colspan="3" class="center sig-box"><br>
                <br>PPTK
                <span class="name-underlined">{{ $register->nama_pptk }}</span>
                NIP {{ $register->nip_pptk }}
            </td>
            <td colspan="3" class="sig-box">
                KLATEN,<br><br><center>BENDAHARA PENGELUARAN</center>
                <center><span class="name-underlined">{{ $register->nama_bendahara }}</span></center>
                <center>{{ $register->nip_bendahara }}</center>
            </td>
        </tr>
        <td colspan="9" class="no-border">
            No Referensi : {{ $register->gen_no_reg }}
        </td>
        </tr>
        <tr>
            <td colspan="5" class="no-border"></td>
            <td colspan="4" class="no-border">
                <table>
                    <tr>
                        <td colspan="3">TELAH DIVERIFIKASI</td>
                    </tr>
                    <tr>
                        <td width="50%">OLEH</td>
                        <td width="25%">TANGGAL</td>
                        <td width="25%">PARAF</td>
                    </tr>
                    <tr>
                        <td>{{ $register->verifikator1 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @if($register->verifikator1 <> $register->verifikator2)
                    <tr>
                        <td>{{ $register->verifikator2 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

<script>
    document.querySelectorAll('.rupiah').forEach(el => {
        const angka = parseInt(el.innerText);
        el.innerText = 'Rp ' + angka.toLocaleString('id-ID');
    });
</script>