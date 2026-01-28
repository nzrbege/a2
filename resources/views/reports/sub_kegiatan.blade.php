@extends('layouts.app')

@push('styles')
<style>
    .header-bg { background-color: #4f46e5; color: white; }
    .subheader-bg { background-color: #8ec7d1; color: #002060; }
    .data-blue { background-color: #deebf7; }
    .data-green-light { background-color: #e2f0d9; }
    .text-red-dark { color: #c00000; }
    .dashboard-link {
        display: inline-block; margin-bottom: 1rem; padding: 0.5rem 1rem;
        background-color: #4f46e5; color: white; font-weight: 500;
        border-radius: 0.375rem; text-decoration: none; transition: background-color 0.3s;
    }
    .dashboard-link:hover { background-color: #3730a3; }
</style>
@endpush

@section('content')

<div class="header-bg text-center py-4 mb-8 rounded-lg shadow-xl">
    <h1 class="text-xl font-extrabold">CEK KENDALI SUB KEGIATAN</h1>
    <p class="text-sm font-medium">BERDASARKAN AKUN REKENING</p>
    <p class="text-xs font-light">DISKOMINFO KABUPATEN KLATEN TAHUN ANGGARAN 2025</p>
</div>

<div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden mb-6">
    <div class="grid grid-cols-6 divide-x divide-slate-300 text-xs text-center">
        <div class="subheader-bg p-2 font-bold">Program</div>
        <div class="subheader-bg p-2 font-bold">Kegiatan</div>
        <div class="subheader-bg p-2 font-bold col-span-2">Sub Kegiatan</div>
        <div class="subheader-bg p-2 font-bold col-span-2">Tahun Anggaran</div>
        
        <div class="data-green-light p-2 font-semibold">2.16.03</div>
        <div class="data-green-light p-2 font-semibold">2.16.03.2.02</div>
        <div class="data-green-light p-2 font-semibold col-span-2">Koordinasi Pemanfaatan Pusat Data Nasional</div>
        <div class="data-green-light p-2 font-semibold col-span-2">2025</div>
    </div>
    <div class="grid grid-cols-1 divide-y divide-slate-300">
        <div class="bg-slate-50 p-2 text-xs text-center italic text-slate-600">
            PROGRAM PENGELOLAAN APLIKASI INFORMATIKA - Pengelolaan E-government di Lingkup Pemerintah Daerah Kabupaten/Kota
        </div>
    </div>
</div>

<div class="bg-white table-container border-t border-slate-200">
    <div class="px-4 py-2 text-sm font-bold text-slate-700">d. Laporan Kendali Rinci (Detail)</div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left min-w-[1400px] border border-slate-300">
            <thead class="bg-slate-100 text-slate-700 uppercase font-bold">
                <tr>
                    <th class="p-2 border border-slate-300 w-24">Kode Akun</th>
                    <th class="p-2 border border-slate-300 min-w-80">Uraian Akun</th>
                    <th class="p-2 border border-slate-300 w-28 text-right">Anggaran</th>
                    <th class="p-2 border border-slate-300 w-28 text-right">SPD-TW IV</th>
                    <th class="p-2 border border-slate-300 w-28 text-right">Realisasi <br>(Di-SAH-kan)</th>
                    <th class="p-2 border border-slate-300 w-28 text-right bg-blue-50">Pending</th>
                    <th class="p-2 border border-slate-300 w-28 text-right bg-red-100 text-red-dark">Sisa Anggaran <br> dari SPD</th>
                    <th class="p-2 border border-slate-300 w-28 text-right bg-green-100">Sisa dari <br> Anggaran</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">
                @php
                $rows = [
                    ["5.1.02.01.01.0024", "Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Tulis Kantor", 907700, 907700, 878229, 0, 29471, 29471],
                    ["5.1.02.01.01.0025", "Belanja Alat/Bahan untuk Kegiatan Kantor-Kertas dan Cover", 1275000, 1275000, 1258740, 0, 16260, 16260],
                    ["5.1.02.01.01.0029", "Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer", 634800, 634800, 632700, 0, 2100, 2100],
                    ["5.1.02.01.01.0052", "Belanja Makanan dan Minuman Rapat", 3710000, 3710000, 3570000, 0, 140000, 140000],
                    ["5.1.02.02.01.0029", "Belanja Jasa Tenaga Ahli", 96000000, 96000000, 72000000, 0, 24000000, 24000000],
                    ["5.1.02.02.08.0019", "Belanja Jasa Narasumber", 18800000, 18800000, 5000000, 0, 13800000, 13800000],
                    ["5.1.02.02.09.0014", "Belanja Jasa Konsultansi", 50000000, 50000000, 0, 50000000, 50000000, 50000000],
                    ["5.1.03.04.01.0001", "Belanja Perjalanan Dinas Biasa", 28298000, 28298000, 5538500, 420000, 22339500, 22339500],
                    ["5.1.03.04.0004", "Belanja Perjalanan Meeting Dalam Kota", 0, 0, 0, 0, 0, 0],
                ];
                @endphp

                @foreach ($rows as $row)
                <tr class="hover:bg-slate-50">
                    <td class="p-2 border border-slate-300 text-blue-700 font-medium">{{ $row[0] }}</td>
                    <td class="p-2 border border-slate-300">{{ $row[1] }}</td>
                    <td class="p-2 border border-slate-300 text-right">{{ number_format($row[2],0,',','.') }}</td>
                    <td class="p-2 border border-slate-300 text-right">{{ number_format($row[3],0,',','.') }}</td>
                    <td class="p-2 border border-slate-300 text-right">{{ number_format($row[4],0,',','.') }}</td>
                    <td class="p-2 border border-slate-300 text-right data-blue">{{ number_format($row[5],0,',','.') }}</td>
                    <td class="p-2 border border-slate-300 text-right text-red-dark bg-red-50">{{ number_format($row[6],0,',','.') }}</td>
                    <td class="p-2 border border-slate-300 text-right font-medium bg-green-50">{{ number_format($row[7],0,',','.') }}</td>
                </tr>
                @endforeach

                <tr class="font-extrabold bg-slate-200">
                    <td class="p-2 border border-slate-300 text-center" colspan="2">TOTAL</td>
                    <td class="p-2 border border-slate-300 text-right">194.624.000</td>
                    <td class="p-2 border border-slate-300 text-right">194.624.000</td>
                    <td class="p-2 border border-slate-300 text-right">83.878.969</td>
                    <td class="p-2 border border-slate-300 text-right">420.000</td>
                    <td class="p-2 border border-slate-300 text-right text-red-dark">110.325.031</td>
                    <td class="p-2 border border-slate-300 text-right bg-green-100">110.325.031</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
