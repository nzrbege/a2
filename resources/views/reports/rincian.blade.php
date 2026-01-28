@extends('layouts.app')

@push('styles')
<style>
    /* Skema Warna Kustom dari Gambar Laporan */
    .header-bg { background-color: #4f46e5; color: white; }
    .bg-program { background-color: #f2dcde; color: #c00000; }
    .bg-kegiatan { background-color: #fde4e2; color: #c00000; }
    .bg-sub-kegiatan { background-color: #fff2cc; color: #990033; }
    .bg-rekening { background-color: #f7e6e5; color: #002060; }
    .data-blue-light { background-color: #deebf7; color: #002060; }
    .data-green-light { background-color: #e2f0d9; color: #002060; }
    .text-red-dark { color: #c00000; }
    .bg-komponen-header { background-color: #4f46e5; color: white; }
    .bg-realisasi-table { background-color: #ffc7ce; }
    .min-w-full-report { min-width: 2000px; }
</style>
@endpush

@section('content')
<div class="header-bg text-center py-4 mb-6 rounded-lg shadow-lg">
    <h1 class="text-xl font-extrabold">DASHBOARD CEK KENDALI RINCIAN BELANJA</h1>
    <p class="text-sm font-medium">BERDASARKAN AKUN REKENING DAN SUB KEGIATAN</p>
    <p class="text-xs font-light">DISKOMINFO KABUPATEN KLATEN TAHUN ANGGARAN 2025</p>
</div>

<div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden mb-8">
    <div class="p-4 border-b bg-slate-100">
        <h2 class="text-lg font-bold text-slate-700">Detail Anggaran & Rencana Belanja</h2>
    </div>
    
    <div class="grid grid-cols-12 text-xs divide-x divide-slate-300">
        
        <div class="col-span-12 md:col-span-5 lg:col-span-4 p-3 space-y-2">
            <div class="flex">
                <span class="bg-program p-1 font-bold w-1/3 border">Program</span>
                <span class="p-1 w-2/3 border border-l-0">2.16.03 - PROGRAM PENGELOLAAN APLIKASI INFORMATIKA</span>
            </div>
            <div class="flex">
                <span class="bg-kegiatan p-1 font-bold w-1/3 border">Kegiatan</span>
                <span class="p-1 w-2/3 border border-l-0">2.16.03.2.02 - Pengelolaan E-government di Lingkup Pemerintah Daerah Kabupaten/Kota</span>
            </div>
            <div class="flex">
                <span class="bg-sub-kegiatan p-1 font-bold w-1/3 border">Sub Kegiatan</span>
                <span class="p-1 w-2/3 border border-l-0">2.16.03.2.02.0014 - Penyelenggaraan Jaringan Intra Pemerintah Daerah Kabupaten/Kota</span>
            </div>
            <div class="flex">
                <span class="bg-rekening p-1 font-bold w-1/3 border">Rekening</span>
                <span class="p-1 w-2/3 border border-l-0">5.1.02.04.01.0001 - Belanja Perjalanan Dinas Biasa</span>
            </div>

            <div class="pt-3">
                <div class="p-2 border font-bold text-center bg-yellow-100">SISA DISEDIAKAN DALAM PENGESAHAN</div>
                <div class="flex justify-between p-2 border border-t-0 text-red-dark">
                    <span class="font-bold">Total:</span>
                    <span class="font-extrabold">10.000.000,00</span>
                </div>
                <div class="p-2 border border-t-0 text-center font-bold bg-green-200">
                    SISA ANGGARAN DARI SPD YANG HARUS DI SAH KAN:
                    <span class="text-red-dark block text-lg">840.000,00</span>
                </div>
            </div>
        </div>

        <div class="col-span-12 md:col-span-4 lg:col-span-4 p-3 space-y-3">
            <div class="flex justify-between p-2 font-bold bg-indigo-100 rounded-md">
                <span>DETAIL SPD</span>
                <span>Sisa Anggaran Sub Kegiatan</span>
            </div>
            <div class="space-y-1">
                <div class="flex justify-between text-sm">
                    <span class="font-semibold">Sub Kegiatan:</span>
                    <span class="font-bold text-green-700">8.000.000,00 (+ / -)</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="font-semibold">Rekening:</span>
                    <span class="font-bold text-purple-700">54.000.000,00 (+ / -)</span>
                </div>
            </div>
            
            <div class="border border-slate-300">
                <div class="bg-blue-200 text-sm font-bold p-1 text-center">BKK TRIWULAN</div>
                <table class="w-full text-xs text-center border-collapse">
                    <thead>
                        <tr class="bg-blue-100">
                            <th class="p-1 border">Triwulan</th>
                            <th class="p-1 border">Real.</th>
                            <th class="p-1 border">Pending</th>
                            <th class="p-1 border">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="data-blue-light">
                            <td class="p-1 border font-bold">TW-I</td>
                            <td class="p-1 border text-right">205.000</td>
                            <td class="p-1 border text-right">25.300</td>
                            <td class="p-1 border font-bold text-right">230.300</td>
                        </tr>
                        <tr class="data-blue-light">
                            <td class="p-1 border font-bold">TW-II</td>
                            <td class="p-1 border text-right">168.040</td>
                            <td class="p-1 border text-right">0</td>
                            <td class="p-1 border font-bold text-right">168.040</td>
                        </tr>
                        <tr class="data-blue-light">
                            <td class="p-1 border font-bold">TW-IV</td>
                            <td class="p-1 border text-right">21.000</td>
                            <td class="p-1 border text-right">25.200</td>
                            <td class="p-1 border font-bold text-right">46.200</td>
                        </tr>
                        <tr class="bg-blue-300 font-bold">
                            <td class="p-1 border">TOTAL</td>
                            <td class="p-1 border text-right">394.040</td>
                            <td class="p-1 border text-right">50.500</td>
                            <td class="p-1 border text-red-dark text-right">444.540</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-span-12 md:col-span-3 lg:col-span-4 p-3">
            <div class="border border-slate-300">
                <div class="bg-green-200 text-sm font-bold p-1 text-center">RENCANA ANGGARAN KAS BULANAN</div>
                <table class="w-full text-xs text-center border-collapse">
                    <thead>
                        <tr class="bg-green-100">
                            <th class="p-1 border">Bulan</th>
                            <th class="p-1 border">Angg.</th>
                            <th class="p-1 border">Real.</th>
                            <th class="p-1 border">Sisa</th>
                            <th class="p-1 border">Vol.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                            [1, 25300, 5, 25200, 20],
                            [2, 25200, 7, 25200, 10],
                            [3, 25300, 4, 25200, 12],
                            [4, 25200, 0, 25200, 0],
                            [5, 25300, 0, 25200, 0],
                            [6, 25200, 0, 25200, 0],
                        ] as $row)
                        <tr class="data-green-light">
                            <td class="p-1 border">{{ $row[0] }}</td>
                            <td class="p-1 border text-right">{{ number_format($row[1], 0, ',', '.') }}</td>
                            <td class="p-1 border text-right">{{ $row[2] }}</td>
                            <td class="p-1 border text-right">{{ number_format($row[3], 0, ',', '.') }}</td>
                            <td class="p-1 border text-center">{{ $row[4] }}</td>
                        </tr>
                        @endforeach
                        <tr class="bg-green-300 font-bold">
                            <td class="p-1 border" colspan="5">TOTAL RAK</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
     <div class="bg-komponen-header px-4 py-3 text-sm font-bold flex justify-between items-center">
         <span><i data-feather="list" class="w-4 h-4 mr-2 inline-block align-text-bottom"></i> Rincian Komponen Belanja</span>
         <button type="button" class="text-xs text-white bg-black/20 hover:bg-black/40 px-3 py-1 rounded font-medium transition-colors flex items-center gap-1">
             <i data-feather="download" class="w-3 h-3"></i> Export Excel
         </button>
     </div>
     
     <div class="overflow-x-auto">
         <table class="w-full text-xs text-left border border-collapse min-w-full-report">
             <thead class="uppercase font-bold text-center">
                 <tr class="text-slate-700">
                     <th rowspan="2" class="p-2 border bg-slate-100 min-w-[70px]">ID Komponen</th>
                     <th rowspan="2" class="p-2 border bg-slate-100 min-w-[300px]">Uraian Komponen</th>
                     <th colspan="4" class="p-2 border bg-indigo-100">Anggaran (DPA)</th>
                     <th colspan="4" class="p-2 border bg-realisasi-table">Realisasi dan Pending</th>
                     <th rowspan="2" class="p-2 border bg-green-200 text-red-dark min-w-[120px]">Sisa dari Anggaran</th>
                     <th rowspan="2" class="p-2 border bg-red-200 text-red-dark min-w-[120px]">Sisa dari SPD</th>
                 </tr>
                 <tr class="text-slate-600">
                     <th class="p-2 border bg-indigo-50 min-w-[70px]">Satuan</th>
                     <th class="p-2 border bg-indigo-50 min-w-[50px]">Vol</th>
                     <th class="p-2 border bg-indigo-50 min-w-[100px]">Harga Satuan</th>
                     <th class="p-2 border bg-indigo-50 min-w-[120px]">Total</th>
                     <th class="p-2 border bg-red-100 min-w-[120px]">Pengeluaran</th>
                     <th class="p-2 border bg-red-100 min-w-[50px]">Vol</th>
                     <th class="p-2 border bg-red-100 min-w-[120px]">Register SAH</th>
                     <th class="p-2 border bg-red-100 min-w-[50px]">Vol SAH</th>
                 </tr>
             </thead>
             <tbody class="divide-y divide-slate-100">
                 <!-- Example Static Data -->
                 <tr class="hover:bg-slate-50">
                     <td class="p-2 border font-medium text-blue-700 text-center">2605517</td>
                     <td class="p-2 border">Uang Harian Perjalanan Dinas Luar Kota, 9 Hari</td>
                     <td class="p-2 border text-center">Org / Hari</td>
                     <td class="p-2 border text-center">15</td>
                     <td class="p-2 border text-right">260.000</td>
                     <td class="p-2 border text-right font-medium bg-indigo-50">3.900.000</td>
                     <td class="p-2 border text-right bg-red-50">4.770.000</td>
                     <td class="p-2 border text-center bg-red-50">9</td>
                     <td class="p-2 border text-right bg-red-50">1.800.000</td>
                     <td class="p-2 border text-center bg-red-50">9</td>
                     <td class="p-2 border text-right font-bold bg-green-50 text-red-dark">2.100.000</td>
                     <td class="p-2 border text-right font-bold bg-red-50 text-red-dark">4.770.000</td>
                 </tr>
             </tbody>
         </table>
     </div>
</div>
@endsection
