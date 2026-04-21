<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Register;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Register::query()->where('opd_id', $user->opd_id)
            ->where('unit_id', $user->unit_id);

        $tanggalMulai   = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('created_at', [
                $tanggalMulai  . ' 00:00:00',
                $tanggalSelesai . ' 23:59:59'
            ]);
        }

        $base = clone $query;

        $total           = (clone $base)->sum('nom_bruto');
        $pending         = (clone $base)->whereNull('cek_sah')->sum('nom_bruto');
        $disahkan        = (clone $base)->where('cek_sah', 'sah')->sum('nom_bruto');
        $jumlahTransaksi = (clone $base)->count();

        // =========================
        // RKA (pagu per sub kegiatan)
        // =========================
        $idVersi = DB::table('versi_anggaran')
            ->orderByDesc('id')
            ->value('id_versi_anggaran');

        $rka = DB::table('rincian_rka as rka')
            ->leftJoinSub(
                DB::table('register')
                    ->select('kd_subkeg', DB::raw('SUM(nom_bruto) as realisasi'))
                    ->where('opd_id', $user->opd_id)
                    ->where('unit_id', $user->unit_id)
                    ->groupBy('kd_subkeg'),
                'real',
                'rka.kode_sub_giat', '=', 'real.kd_subkeg'
            )
            ->select(
                'rka.kode_program', 'rka.nama_program',
                'rka.kode_giat',    'rka.nama_giat',
                'rka.kode_sub_giat','rka.nama_sub_giat',
                DB::raw('SUM(rka.total_harga) as pagu'),
                DB::raw('COALESCE(real.realisasi, 0) as realisasi')
            )
            ->where('rka.id_versi_anggaran', $idVersi)
            ->where('rka.opd_id',  $user->opd_id)
            ->where('rka.unit_id', $user->unit_id)
            ->groupBy(
                'rka.kode_program', 'rka.nama_program',
                'rka.kode_giat',    'rka.nama_giat',
                'rka.kode_sub_giat','rka.nama_sub_giat',
                'real.realisasi'
            )
            ->orderBy('rka.kode_program')
            ->orderBy('rka.kode_giat')
            ->get();

        // =========================
        // REKENING PER SUB KEGIATAN
        // Join ke tabel master rekening untuk ambil nama.
        // Sesuaikan nama tabel & kolom jika berbeda di database Anda:
        //   tabel : rekening        (atau kode_rekening, ref_rekening, dll.)
        //   FK    : kd_rekbel       (kolom kode di tabel rekening)
        //   nama  : nama_rekbel     (kolom nama di tabel rekening)
        // =========================
        $rekeningPerSubkeg = (clone $base)
            ->select(
                'register.kd_subkeg',
                'register.kd_rekbel',
                DB::raw("COALESCE(register.urai_rekbel, '') as nama_rekbel"),
                DB::raw('SUM(register.nom_bruto) as total')
            )
            // ->leftJoin(
            //     'rekening as rek',
            //     'register.kd_rekbel', '=', 'rek.kd_rekbel'
            // )
            ->groupBy('register.kd_subkeg', 'register.kd_rekbel', 'register.urai_rekbel')
            ->orderBy('register.kd_subkeg')
            ->orderByDesc('total')
            ->get()
            ->groupBy('kd_subkeg');

        // =========================
        // SUSUN HIRARKI dengan rollup realisasi ke parent
        // =========================
        $hirarki = $rka->groupBy('kode_program')->map(function ($progRows) use ($rekeningPerSubkeg) {

            $kegiatanMap = $progRows->groupBy('kode_giat')->map(function ($kegRows) use ($rekeningPerSubkeg) {

                $subkegList = $kegRows->map(function ($sub) use ($rekeningPerSubkeg) {
                    $pagu      = (float) $sub->pagu;
                    $realisasi = (float) $sub->realisasi;
                    $persen    = $pagu > 0 ? round(($realisasi / $pagu) * 100, 2) : 0;

                    return [
                        'kode'      => $sub->kode_sub_giat,
                        'nama'      => $sub->nama_sub_giat,
                        'pagu'      => $pagu,
                        'realisasi' => $realisasi,
                        'persen'    => $persen,
                        'sisa'      => $pagu - $realisasi,
                        'rekening'  => $rekeningPerSubkeg->get($sub->kode_sub_giat, collect()),
                    ];
                });

                // Rollup ke level Kegiatan
                $paguKeg      = $subkegList->sum('pagu');
                $realisasiKeg = $subkegList->sum('realisasi');
                $persenKeg    = $paguKeg > 0 ? round(($realisasiKeg / $paguKeg) * 100, 2) : 0;

                return [
                    'nama_keg'  => $kegRows->first()->nama_giat,
                    'pagu'      => $paguKeg,
                    'realisasi' => $realisasiKeg,
                    'sisa'      => $paguKeg - $realisasiKeg,
                    'persen'    => $persenKeg,
                    'subkeg'    => $subkegList,
                ];
            });

            // Rollup ke level Program
            $paguProg      = $kegiatanMap->sum('pagu');
            $realisasiProg = $kegiatanMap->sum('realisasi');
            $persenProg    = $paguProg > 0 ? round(($realisasiProg / $paguProg) * 100, 2) : 0;

            return [
                'nama_prog'  => $progRows->first()->nama_program,
                'pagu'       => $paguProg,
                'realisasi'  => $realisasiProg,
                'sisa'       => $paguProg - $realisasiProg,
                'persen'     => $persenProg,
                'kegiatan'   => $kegiatanMap,
            ];
        });

        // =========================
        // REKAP REKENING global (sidebar) — dengan nama rekening
        // =========================
        $rekapRekening = (clone $base)
            ->select(
                'register.kd_rekbel',
                DB::raw("COALESCE(register.urai_rekbel, '') as nama_rekbel"),
                DB::raw('SUM(register.nom_bruto) as total')
            )
            // ->leftJoin('rincian_rka as rek', 'register.kd_rekbel', '=', 'rek.kd_rekbel')
            ->groupBy('register.kd_rekbel', 'register.urai_rekbel')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topPengeluaran    = (clone $base)->orderByDesc('nom_bruto')->limit(5)->get();
        $transaksiTerakhir = (clone $base)->orderByDesc('created_at')->limit(5)->get();

        return view('dashboard', [
            'total'             => $total,
            'pending'           => $pending,
            'disahkan'          => $disahkan,
            'jumlahTransaksi'   => $jumlahTransaksi,
            'hirarki'           => $hirarki,
            'rekapRekening'     => $rekapRekening,
            'topPengeluaran'    => $topPengeluaran,
            'transaksiTerakhir' => $transaksiTerakhir,
        ]);
    }
}
