<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RincianRka;

class DashboardController extends Controller
{
    public function ringkasan()
    {
        return view('dashboard.ringkasan');
    }

    public function kendaliSubKegiatan()
    {
        $data = [];
        $total_anggaran = 100000;
        $total_spd = 10000;
        $total_sah = 1000;
        $total_pending = 190;
        $total_sisa_spd = 280;
        $total_sisa_anggaran = 2198;
        $total_realisasi = 2213;
        $programs = RincianRka::where('id_versi_anggaran', 'P1')
            ->select('kode_program', 'nama_program')
            ->groupBy('kode_program', 'nama_program')
            ->orderBy('kode_program')
            ->get();

        return view('dashboard.kendali-sub-kegiatan', compact('programs', 'data', 'total_anggaran', 'total_spd', 'total_sah', 'total_pending', 'total_sisa_spd','total_sisa_anggaran','total_realisasi'));
    }
}
