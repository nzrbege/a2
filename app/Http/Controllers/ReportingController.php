<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RincianRka;
use App\Models\VersiAnggaran;
use App\Models\Opd;
use Illuminate\Support\Facades\DB;

    use Barryvdh\DomPDF\Facade\Pdf;

class ReportingController extends Controller
{
    public function realisasi(Request $request)
    {
        $user = auth()->user();
        
        $kode_opd = Opd::where('id', $user->opd_id)->value('kode_singkat');

        // =========================
        // SIMPAN FILTER KE SESSION (POST)
        // =========================
        if ($request->isMethod('post')) {

            session([
                'filter' => [
                    'program' => $request->program,
                    'kegiatan' => $request->kegiatan,
                    'sub_kegiatan' => $request->sub_kegiatan,
                    'mode' => $request->mode ?? 'rekening',
                ]
            ]);

            return redirect()->route('reporting.realisasi');
        }

        // =========================
        // AMBIL FILTER DARI SESSION
        // =========================
        $filter = session('filter', []);
        $mode = $filter['mode'] ?? 'rekening';

        // =========================
        // DUMMY DATA
        // =========================
        $data = collect([
            (object)[
                'program' => 'Program Pendidikan',
                'kegiatan' => 'Pengelolaan Sekolah',
                'sub_kegiatan' => 'Operasional SD',
                'rekening' => 'Belanja ATK',
                'pagu' => 10000000,
                'realisasi' => 6500000,
            ],
            (object)[
                'program' => 'Program Pendidikan',
                'kegiatan' => 'Pengelolaan Sekolah',
                'sub_kegiatan' => 'Operasional SMP',
                'rekening' => 'Belanja Modal',
                'pagu' => 15000000,
                'realisasi' => 12000000,
            ],
            (object)[
                'program' => 'Program Kesehatan',
                'kegiatan' => 'Pelayanan Puskesmas',
                'sub_kegiatan' => 'Pengadaan Obat',
                'rekening' => 'Belanja Barang',
                'pagu' => 20000000,
                'realisasi' => 5000000,
            ],
        ]);

        // =========================
        // FILTER DATA
        // =========================
        if (!empty($filter['program'])) {
            $data = $data->where('program', $filter['program']);
        }

        if (!empty($filter['kegiatan'])) {
            $data = $data->where('kegiatan', $filter['kegiatan']);
        }

        if (!empty($filter['sub_kegiatan'])) {
            $data = $data->where('sub_kegiatan', $filter['sub_kegiatan']);
        }

        // =========================
        // GROUPING SESUAI MODE
        // =========================
        switch ($mode) {

            case 'program':
                $data = $data->groupBy('program')->map(function ($items, $key) {
                    return (object)[
                        'program' => $key,
                        'pagu' => $items->sum('pagu'),
                        'realisasi' => $items->sum('realisasi'),
                    ];
                })->values();
                break;

            case 'kegiatan':
                $data = $data->groupBy('kegiatan')->map(function ($items, $key) {
                    return (object)[
                        'kegiatan' => $key,
                        'pagu' => $items->sum('pagu'),
                        'realisasi' => $items->sum('realisasi'),
                    ];
                })->values();
                break;

            case 'sub_kegiatan':
                $data = $data->groupBy('sub_kegiatan')->map(function ($items, $key) {
                    return (object)[
                        'sub_kegiatan' => $key,
                        'pagu' => $items->sum('pagu'),
                        'realisasi' => $items->sum('realisasi'),
                    ];
                })->values();
                break;

            default:
                // rekening → tampil detail
                break;
        }

        $versiTerbaru = VersiAnggaran::max('id');

        $program = RincianRka::where('versi_anggaran_id', $versiTerbaru)
            ->select('kode_program', 'nama_program')
            ->groupBy('kode_program', 'nama_program')
            ->orderBy('kode_program')
            ->get();

        // =========================
        // RETURN VIEW
        // =========================
        return view('reporting.realisasi', compact(
            'versiTerbaru',
            'data',
            'program',
            'kode_opd',
            // 'kegiatans',
            // 'sub_kegiatans'
        ));
    }


    public function filterRincian(Request $request)
    {
        $data = DB::table('rincian_rka as r')
            ->leftJoinSub(
                DB::table('register')
                    ->join('detail_belanja', 'register.id_reg', '=', 'detail_belanja.id_reg')
                    ->where('register.kd_keg', $request->input('kegiatan'))
                    ->where('register.kd_subkeg', $request->input('sub_kegiatan'))
                    ->where('register.kd_rekbel', $request->input('akun'))
                    ->select(
                        'detail_belanja.id_rinci_sub_bl',
                        'detail_belanja.volume',
                        'detail_belanja.total_dibayar',
                        'register.cek_sah'
                    ),
                'd',
                function ($join) {
                    $join->on('d.id_rinci_sub_bl', '=', 'r.id_rinci_sub_bl');
                }
            )
            ->where('r.kode_giat', $request->input('kegiatan'))
            ->where('r.kode_sub_giat', $request->input('sub_kegiatan'))
            ->where('r.kode_akun', $request->input('akun'))
            ->where('r.versi_anggaran_id', $request->input('versi'))
            ->groupBy(
                'r.id_rinci_sub_bl',
                'r.nama_komponen',
                'r.satuan',
                'r.volume',
                'r.harga_satuan',
                'r.kode_dana',
                'r.nama_dana',
                'r.kode_skpd',
                'r.nama_skpd',
                'r.pptk_id',
                'r.pokja_id'
            )
            ->select(
                'r.id_rinci_sub_bl',
                'r.nama_komponen',
                'r.satuan',
                'r.volume',
                'r.harga_satuan',
                'r.kode_dana',
                'r.nama_dana',
                'r.kode_skpd',
                'r.nama_skpd',
                'r.pptk_id',
                'r.pokja_id',

                // PENDING
                DB::raw("COALESCE(SUM(CASE WHEN d.cek_sah IS NULL THEN d.volume ELSE 0 END), 0) as vol_pending"),
                DB::raw("COALESCE(SUM(CASE WHEN d.cek_sah IS NULL THEN d.total_dibayar ELSE 0 END), 0) as nom_pending"),

                // SAH
                DB::raw("COALESCE(SUM(CASE WHEN d.cek_sah = 'sah' THEN d.volume ELSE 0 END), 0) as vol_sah"),
                DB::raw("COALESCE(SUM(CASE WHEN d.cek_sah = 'sah' THEN d.total_dibayar ELSE 0 END), 0) as nom_sah")
            )
            ->get()
            ->map(function ($row) {

                $total_rencana = $row->volume * $row->harga_satuan;

                // total realisasi = pending + sah
                $reg_vol = $row->vol_pending + $row->vol_sah;
                $reg_nom = $row->nom_pending + $row->nom_sah;

                return [
                    'id_rinci_sub_bl'   => $row->id_rinci_sub_bl,
                    'nama_komponen'     => $row->nama_komponen,
                    'satuan'            => $row->satuan,
                    'volume'            => $row->volume,
                    'harga_satuan'      => $row->harga_satuan,

                    // breakdown
                    'vol_pending'       => $row->vol_pending,
                    'nom_pending'       => $row->nom_pending,
                    'vol_sah'           => $row->vol_sah,
                    'nom_sah'           => $row->nom_sah,

                    // total realisasi
                    'reg_vol'           => $reg_vol,
                    'reg_nom'           => $reg_nom,

                    // sisa
                    'sisa_vol'          => $row->volume - $reg_vol,
                    'sisa_nom'          => $total_rencana - $reg_nom,

                    // info lain
                    'kode_dana'         => $row->kode_dana,
                    'nama_dana'         => $row->nama_dana,
                    'kode_skpd'         => $row->kode_skpd,
                    'nama_skpd'         => $row->nama_skpd,
                    'pptk_id'           => $row->pptk_id,
                    'pokja_id'          => $row->pokja_id,
                ];
            });
        return response()->json($data);
    }

    public function bulanan(Request $request)
    {        
        $user = auth()->user();

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $data = DB::table('register')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->where('opd_id',$user->opd_id)
            ->where('unit_id',$user->unit_id)
            ->orderBy('kd_prog')
            ->orderBy('kd_keg')
            ->orderBy('kd_subkeg')
            ->orderBy('kd_rekbel')
            ->orderBy('created_at')
            ->get();

        // total keseluruhan
        $total = $data->sum('nom_bruto');

        // grouping
        $grouped = $data->groupBy('kd_prog');

        return view('reporting.laporan_bulanan', compact(
            'grouped',
            'total',
            'bulan',
            'tahun'
        ));
    }

    public function bulananPdf(Request $request)
    {
        $user = auth()->user();
        
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $data = DB::table('register')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->where('opd_id',$user->opd_id)
            ->where('unit_id',$user->unit_id)            
            ->orderBy('kd_prog')
            ->orderBy('kd_keg')
            ->orderBy('kd_subkeg')
            ->orderBy('kd_rekbel')
            ->orderBy('created_at')
            ->get();

        $total = $data->sum('nom_bruto');
        $grouped = $data->groupBy('kd_prog');

        $pdf = Pdf::loadView('reporting.laporan_bulanan_pdf', compact(
            'grouped',
            'total',
            'bulan',
            'tahun'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('laporan-bulanan.pdf');
    }
}
