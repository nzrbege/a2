<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $query = DB::table('register');

        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('created_at', [
                $tanggalMulai . ' 00:00:00',
                $tanggalSelesai . ' 23:59:59'
            ]);
        }
        
        $base = clone $query;
       
        $total = (clone $base)->sum('nom_bruto');

        $pending = (clone $base)
            ->whereNull('cek_sah')
            ->sum('nom_bruto');

        $disahkan = (clone $base)
            ->where('cek_sah', 'sah')
            ->sum('nom_bruto');

        $jumlahTransaksi = (clone $base)->count();

        $idVersi = DB::table('versi_anggaran')
            ->orderByDesc('id')
            ->value('id_versi_anggaran');

        $rka = DB::table('rincian_rka as rka')
            ->leftJoinSub(
                DB::table('register')
                    ->select('kd_subkeg', DB::raw('SUM(nom_bruto) as realisasi'))
                    ->groupBy('kd_subkeg'),
                'real',
                'rka.kode_sub_giat',
                '=',
                'real.kd_subkeg'
            )
            ->select(
                'rka.kode_program',
                'rka.nama_program',
                'rka.kode_giat',
                'rka.nama_giat',
                'rka.kode_sub_giat',
                'rka.nama_sub_giat',
                DB::raw('SUM(rka.total_harga) as pagu'),
                DB::raw('COALESCE(real.realisasi,0) as realisasi')
            )
            ->where('rka.id_versi_anggaran', $idVersi)
            ->groupBy(
                'rka.kode_program','rka.nama_program',
                'rka.kode_giat','rka.nama_giat',
                'rka.kode_sub_giat','rka.nama_sub_giat',
                'real.realisasi'
            )
            ->orderBy('rka.kode_program')
            ->orderBy('rka.kode_giat')
            ->get();
        
        $hirarki = $rka->groupBy('kode_program')->map(function ($prog) {
            return [
                'nama_prog' => $prog->first()->nama_program,
                'kegiatan' => $prog->groupBy('kd_keg')->map(function ($keg) {
                    return [
                        'nama_keg' => $keg->first()->nama_giat,
                        'subkeg' => $keg->map(function ($sub) {
                            $persen = $sub->pagu > 0
                                ? round(($sub->realisasi / $sub->pagu) * 100, 2)
                                : 0;
                            return [
                                'kode' => $sub->kode_sub_giat,
                                'nama' => $sub->nama_sub_giat,
                                'pagu' => $sub->pagu,
                                'realisasi' => $sub->realisasi,
                                'persen' => $persen,
                                'sisa' => $sub->pagu - $sub->realisasi,
                            ];
                        })
                    ];
                })
            ];
        });

        // =========================
        // REKAP REKENING
        // =========================
        $rekapRekening = (clone $base)
            ->select('kd_rekbel', DB::raw('SUM(nom_bruto) as total'))
            ->groupBy('kd_rekbel')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topPengeluaran = (clone $base)
            ->orderByDesc('nom_bruto')
            ->limit(5)
            ->get();

        // =========================
        // TRANSAKSI TERAKHIR
        // =========================
        $transaksiTerakhir = (clone $base)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        
            // dd($transaksiTerakhir);

        // =========================
        // RETURN VIEW
        // =========================
        return view('dashboard', [
            'total' => $total,
            'pending' => $pending,
            'disahkan' => $disahkan,
            'jumlahTransaksi' => $jumlahTransaksi,
            'hirarki' => $hirarki,
            'rekapRekening' => $rekapRekening,
            'topPengeluaran' => $topPengeluaran,
            'transaksiTerakhir' => $transaksiTerakhir,
        ]);
    }
}
