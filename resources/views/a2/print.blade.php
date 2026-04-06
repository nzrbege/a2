<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>A2</title>
    <style>
        @page {
            size: A4;
            margin: 0.5cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
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
            font-size: 8pt;
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

    .tabel-verifikasi {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-size: 7pt; /* font lebih kecil */
    }

    .tabel-verifikasi td {
        border: 1px solid #000;
        padding: 3px;
    }

    .col-oleh {
        width: 60%;
    }

    .col-tanggal {
        width: 20%;
    }

    .col-paraf {
        width: 20%;
    }

    .tabel-verifikasi {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed; /* WAJIB supaya colgroup bekerja */
        font-size: 7pt; /* font lebih kecil */
    }

    .tabel-verifikasi td {
        border: 1px solid #000;
        padding: 3px;
        vertical-align: top;
    }
    .tabel-diterima td {
        padding: 2px;     
        border: none;      /* pastikan tanpa border */
        line-height: 1.1;  /* rapatkan tinggi baris */
    }

    .tabel-diterima {
        margin: 0;
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
                Sudah diterima dari Bendahara Pengeluaran Diskominfo Kab. Klaten, uang sejumlah <span>Rp {{ number_format($register->nom_bruto, 2, ',', '.') }}</span>, secara {{ $register->j_transaksi }}
                <br>
                <span class="italic">Terbilang : {{ $register->bruto_terbilang }}</span>
            </td>
        </tr>

        <tr>
            <td colspan="9" class="no-border-bottom">
                <span class="bold">Untuk Pembayaran</span>
                <table class="no-border tabel-diterima">
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
                <table class="no-border tabel-diterima" style="margin-top: 5px;">
                    <tr class="no-border">
                        <td class="no-border" width="120">Nama</td>
                        <td class="no-border" width="10">:</td>
                        <td class="no-border">{{ $register->nama_penerima }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Bank</td>
                        <td class="no-border">:</td>
                        <td class="no-border">{{ $register->bank_penerima }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Rekening/Kode Bayar</td>
                        <td class="no-border">:</td>
                        <td class="no-border">{{ $register->norek_penerima }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">NPWP</td>
                        <td class="no-border">:</td>
                        <td class="no-border">{{ $register->npwp_penerima }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Alamat</td>
                        <td class="no-border">:</td>
                        <td class="no-border">{{ $register->alamat_penerima }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border"></td>
                        <td class="no-border"></td>
                        <td class="no-border"></td>
                    </tr>                  
                    <tr class="no-border">
                        <td class="no-border"></td>
                        <td class="no-border"></td>
                        <td class="no-border center">{{ $register->nama_penerima }}</td>
                    </tr>
                </table>
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
                        {{-- <td class="no-border">{{ ($register->nom_pajak1 === null || $register->nom_pajak1 == 0)? '' : $register->jpajak_1 }}</td> --}}
                        <td class="no-border" colspan="2">{{ (($register->nom_pajak1 !== null || $register->nom_pajak1 <> 0) && $register->jpajak_1 == 'PAD')? '' : ((($register->nom_pajak1 !== null || $register->nom_pajak1 <> 0) && $register->jpajak_1 !== null)?$dpp1:'') }}</td>
                        <td class="no-border colon right">{{ ($register->nom_pajak1 === null || $register->nom_pajak1 == 0)? '' : ':' }}</td>
                        <td class="no-border right">{{ ($register->nom_pajak1 === null || $register->nom_pajak1 == 0)? '' : 'Rp '.number_format($register->nom_pajak1, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="no-border">
                        {{-- <td class="no-border nowrap">{{ ($register->nom_pajak2 === null || $register->nom_pajak2 == 0)? '' : $register->jpajak_2 }}</td> --}}
                        <td class="no-border">{{ (($register->nom_pajak2 !== null || $register->nom_pajak2 <> 0) && $register->jpajak_2 == 'PAD')? '' : ((($register->nom_pajak2 !== null || $register->nom_pajak2 <> 0) && $register->jpajak_2 !== null)?$dpp2:'') }}</td>
                        <td class="no-border colon right">{{ ($register->nom_pajak2 === null || $register->nom_pajak2 == 0)? '' : ':' }}</td>
                        <td class="no-border right">{{ ($register->nom_pajak2 === null || $register->nom_pajak2 == 0)? '' : 'Rp '.number_format($register->nom_pajak2, 2, ',', '.') }}</td>
                    </tr>
                    @if($register->t_iwp !== null && $register->t_iwp != 0)
                    <tr class="no-border">
                        <td class="no-border" colspan="2">IWP (1%)</td>
                        <td class="no-border colon right">:</td>
                        <td class="no-border right">{{ 'Rp '.number_format($register->t_iwp, 2, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="no-border">
                        <td colspan="4" class="left no-border" style="padding: 10px;">Pemungutan oleh Bendaharawan APBD
                        </td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="2" class="right no-border">Jumlah Potongan</td>
                        <td class="no-border right">:</td>
                        <td class="right bold no-border">Rp {{ number_format($register->t_potongan, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="2" style="padding-top: 10px;" class="no-border">Jumlah yang dibayarkan</td>
                        <td class="no-border right">:</td>
                        <td class="right bold no-border" style="padding-top: 10px;">Rp {{ number_format($register->nom_netto, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="no-border">
                        <td class="no-border">Terbilang :</td>
                        <td class="right bold italic no-border" colspan="3">{{ $register->netto_terbilang }}
                    <br/><br/><br/><br/><br/><br/></td>
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
                <table class="tabel-verifikasi">
        <colgroup>
            <col style="width:60%">
            <col style="width:20%">
            <col style="width:20%">
        </colgroup>
                    <tr>
            <td colspan="3" class="bold">TELAH DIVERIFIKASI</td>
        </tr>
        <tr>
            <td>OLEH</td>
            <td>TANGGAL</td>
            <td>PARAF</td>
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

    function terbilangInt(n) {
        n = Math.floor(n);

        const angka = ["", "Satu", "Dua", "Tiga", "Empat", "Lima",
            "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
        ];

        if (n < 12) return angka[n];
        if (n < 20) return terbilangInt(n - 10) + " Belas";
        if (n < 100) return terbilangInt(Math.floor(n / 10)) + " Puluh " + terbilangInt(n % 10);
        if (n < 200) return "Seratus " + terbilangInt(n - 100);
        if (n < 1000) return terbilangInt(Math.floor(n / 100)) + " Ratus " + terbilangInt(n % 100);
        if (n < 2000) return "Seribu " + terbilangInt(n - 1000);
        if (n < 1000000) return terbilangInt(Math.floor(n / 1000)) + " Ribu " + terbilangInt(n % 1000);
        if (n < 1000000000) return terbilangInt(Math.floor(n / 1000000)) + " Juta " + terbilangInt(n % 1000000);

        return "";
    }

    function terbilang(n) {
        n = Number(n);

        if (isNaN(n)) return "";

        const rupiah = Math.floor(n);
        const sen = Math.round((n - rupiah) * 100);

        let hasil = terbilangInt(rupiah);

        if (sen > 0) {
            hasil += " " + terbilangInt(sen) + " Sen";
        }

        return hasil.trim();
    }
</script>