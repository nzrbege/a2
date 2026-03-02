<?php

namespace App\Http\Controllers;

use App\Models\DetailBelanja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VersiAnggaran;
use App\Models\RincianRka;
use App\Models\Penerima;
use App\Models\Dpp;
use App\Models\MasterPejabat;
use App\Models\PengeluaranA2;
use App\Models\Register;
use App\Models\Pptk;
use App\Models\Pokja;
use App\Models\TarifPpn;
use Illuminate\Support\Facades\Log;


class A2Controller extends Controller
{
    public function create()
    {
        $versi = VersiAnggaran::all();

        $penerima = Penerima::orderBy('penerima')->get();

        $dpp = Dpp::all();
        $ppn = TarifPpn::find(1);

        return view('a2.create', compact(
            'versi',
            'penerima',
            'dpp',
            'ppn'
        ));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // ================= VALIDASI =================

            $request->validate([
                'versi' => 'required',
                // 'tanggal' => 'required',
                'program' => 'required',
                'nama_program' => 'required',
                'kegiatan' => 'required',
                'nama_giat' => 'required',
                'sub_kegiatan' => 'required',
                'nama_sub_giat' => 'required',
                'kode_akun' => 'required',
                'nama_akun' => 'required',
                // 'keperluan' => 'required',
                'bruto' => 'required',
                // 'pajakPotong' => 'required',
                'nom_netto' => 'required',
                'riil' => 'required|array',
                'nama_penerima' => 'required',
                'bank_penerima' => 'required',
                'norek_penerima' => 'required',
            ]);



            $riilValid = collect($request->riil)
                ->first(function ($row) {
                    return
                        !empty($row['vol']) &&
                        !empty($row['harga']) &&
                        (int) $row['vol'] > 0 &&
                        (int) str_replace('.', '', $row['harga']) > 0;
                });

            if (!$riilValid) {
                throw new \Exception('Tidak ada data riil yang memiliki volume dan harga');
            }

            // ================= NOMOR REGISTER =================
            $lastNumber = DB::table('register')
                ->selectRaw("MAX(CAST(SUBSTRING_INDEX(gen_no_reg,'/',1) AS UNSIGNED)) as last_number")
                ->value('last_number') ?? 0;

            $nomorUrut = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $tahun = now()->year;
            $jenis = ($request->tata_usaha == 'LS' ? 'LS/' : '') . $request->transaksi;
            $sdana = $riilValid['kode_dana'] == '1.1.01' ? 'PAD': ($riilValid['kode_dana'] == '1.2.01.08' ? 'DAU' : ($riilValid['kode_dana'] == '1.4.01' ? 'SILPA' : ($riilValid['kode_dana'] == '2.2.01.07.01.0004' ? 'DBHCHT' : "")));

            $nomorSurat = "{$nomorUrut}/BP/{$jenis}/$sdana/{$request->sub_kegiatan}/DISKOMINFO/{$tahun}";

            $pejabat = MasterPejabat::where('kode_skpd', $riilValid['kode_skpd'])->first();
            $pptk = Pptk::findOrFail($riilValid['pptk_id']);
            $pokja = Pokja::findOrFail($riilValid['pokja_id']);

            $pajak = $request->input('pajak', []);

            $kode   = $pajak['kode']    ?? [];
            $jenis  = $pajak['jenis']   ?? [];
            $nominal= $pajak['nominal'] ?? [];

            // ================= HEADER =================
            $register = Register::create([
                'gen_no_reg'  => $nomorSurat,
                'no_dpa'      => $request->no_dpa,
                'tanggal'     => $request->tanggal,
                'kd_prog'     => $request->program,
                'kd_keg'      => $request->kegiatan,
                'kd_subkeg'   => $request->sub_kegiatan,
                'urai_prog'   => $request->nama_program,
                'urai_keg'    => $request->nama_giat,
                'urai_subkeg' => $request->nama_sub_giat,
                'kd_rekbel'   => $request->kode_akun,
                'urai_rekbel' => $request->nama_akun,
                'jenis_tu'    => $request->tata_usaha,
                'jenis_a2'    => $request->jenis_a2,
                'j_transaksi' => $request->transaksi,
                'npwp_penerima' => $request->npwp,
                'nom_bruto'   => (int) str_replace('.', '', $request->bruto),
                't_pajak'     => (int) str_replace('.', '', $request->pajakPotong),
                'nom_netto'     => (int) str_replace('.', '', $request->nom_netto),
                'nama_penerima'    => $request->nama_penerima,
                'bank_penerima'    => $request->bank_penerima,
                'norek_penerima'    => $request->norek_penerima,
                'alamat_penerima'    => $request->alamat_penerima,
                'keperluan'   => $request->keperluan,
                'bruto_terbilang'   => $request->bruto_terbilang,
                'netto_terbilang'   => $request->netto_terbilang,
                'kode_skpd' => $riilValid['kode_skpd'],
                'nama_skpd' => $riilValid['nama_skpd'],
                'nama_pa'   => $pejabat->nama_pa,
                'nip_pa'    => $pejabat->nip_pa,
                'nama_pptk' => $pptk->nama_pptk,
                'nip_pptk'  => $pptk->nip,
                'nama_bendahara'    => $pejabat->nama_bendahara,
                'nip_bendahara' => $pejabat->nip_bendahara,
                'verifikator1'  => $pejabat->nama_ppk,
                'verifikator2'  => $pokja->nama_kapokja,
                'jpajak_1'   => $jenis[0]   ?? null,
                'kd_pot1'    => $kode[0]    ?? null,
                'id_bill1'   => '',
                'nom_pajak1' => $nominal[0] ?? 0,
                'jpajak_2'   => $jenis[1]   ?? null,
                'kd_pot2'    => $kode[1]    ?? null,
                'id_bill2'   => '',
                'nom_pajak2' => $nominal[1] ?? 0,
            ]);

            // ================= DETAIL RIIL =================
            $detilData = [];

            foreach ($request->riil as $row) {

                if (empty($row['vol']) || empty($row['harga'])) {
                    continue;
                }

                $vol   = (int) $row['vol'];
                $harga = (int) str_replace('.', '', $row['harga']);

                $total_dpp = $vol * $harga;

                $ppn = 0;
                if (!empty($row['ppn'])) {
                    $ppn = $vol * $harga * $request->ppn / 100;
                }

                $total_dibayar = $total_dpp + $ppn;
                
                $detilData[] = [
                    'id_reg'           => $register->id_reg,
                    'no_reg'           => $register->gen_no_reg,
                    'kd_subkeg'        => $register->kd_subkeg,
                    'kd_rek'           => $register->kd_rekbel,
                    'id_rinci_sub_bl'  => $row['id_rinci_sub_bl'],
                    'volume'           => $vol,
                    'harga_riil'       => $harga,
                    'total_dpp'        => $total_dpp,
                    'ppn'              => $ppn,
                    'total_dibayar'    => $total_dibayar,
                ];
            }
            if (empty($detilData)) {
                throw new \Exception('Detail riil kosong');
            }

            DetailBelanja::insert($detilData);

            DB::commit();

            return redirect()
                ->route('a2.show', $register->id_reg)
                ->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal simpan A2', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    public function print($id)
    {
        // In the original, it takes params from URL (GET) for print.
        // We can replicate that.
        $register = Register::with('detailBelanja.rincianRka')->findOrFail($id);

        $nomorsurat = strstr($register->gen_no_reg, "/BP/");
        $nomorsurat = str_replace("/BP/", "", $nomorsurat);

        // dd($register->nom_pajak1);

        return view('a2.print', compact('register','nomorsurat'));
    }

    public function filterRincian(Request $request)
    {
        $versipilihan = VersiAnggaran::where('nomor_anggaran',$request->versi)->value('id_versi_anggaran');

        $subQuery = DB::table('register')
            ->join('detail_belanja', 'register.id_reg', '=', 'detail_belanja.id_reg')
            ->where('kd_keg', $request->input('kegiatan'))
            ->where('register.kd_subkeg', $request->input('sub_kegiatan'))
            ->where('register.kd_rekbel', $request->input('akun'))
            ->select(
                'register.*',
                'detail_belanja.id_rinci_sub_bl',
                'detail_belanja.volume',
                'detail_belanja.harga_riil',
                'detail_belanja.total_dibayar'
            );

        $data = DB::table('rincian_rka as r')
            ->leftJoinSub($subQuery, 'd', function ($join) {
                $join->on('d.id_rinci_sub_bl', '=', 'r.id_rinci_sub_bl');
            })
            ->where('r.kode_giat', $request->input('kegiatan'))
            ->where('r.kode_sub_giat', $request->input('sub_kegiatan'))
            ->where('r.kode_akun', $request->input('akun'))
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
                DB::raw('COALESCE(SUM(d.volume), 0) as reg_sah_vol'),
                DB::raw('COALESCE(SUM(d.total_dibayar), 0) as reg_sah_nom')
            )
            ->get()
            ->map(function ($row) {
                        $total_rencana = $row->volume * $row->harga_satuan;

                        return [
                            'id_rinci_sub_bl'   => $row->id_rinci_sub_bl,
                            'nama_komponen'     => $row->nama_komponen,
                            'satuan'            => $row->satuan,
                            'volume'            => $row->volume,
                            'harga_satuan'      => $row->harga_satuan,
                            'reg_sah_vol'       => $row->reg_sah_vol,
                            'reg_sah_nom'       => $row->reg_sah_nom,
                            'sisa_vol'          => $row->volume - $row->reg_sah_vol,
                            'sisa_nom'          => $total_rencana - $row->reg_sah_nom,
                            'kode_dana'         => $row->kode_dana,
                            'nama_dana'         => $row->nama_dana,
                            'kode_skpd'         => $row->kode_skpd,
                            'nama_skpd'         => $row->nama_skpd,
                            'pptk_id'           => $row->pptk_id,
                            'pokja_id'          => $row->pokja_id,
                        ];
                    });

        // $data = RincianRka::from('rincian_rka as r')
        //     ->leftJoin('register as reg', function ($join) use ($request) {
        //         $join->on('reg.id_reg', '=', 'd.id_reg')
        //             ->where('reg.kd_keg', $request->input('kegiatan'))
        //             ->where('reg.kd_subkeg', $request->input('sub_kegiatan'))
        //             ->where('reg.kd_rekbel', $request->input('akun'));
        //     })
        //     // ->where('r.id_versi_anggaran', $versipilihan)
        //     // ->where('r.kode_program', $request->input('program'))
        //     ->where('r.kode_giat', $request->input('kegiatan'))
        //     ->where('r.kode_sub_giat', $request->input('sub_kegiatan'))
        //     ->where('r.kode_akun', $request->input('akun'))
        //     ->select(
        //         'r.id_rinci_sub_bl',
        //         'r.nama_komponen',
        //         'r.satuan',
        //         'r.volume',
        //         'r.harga_satuan',
        //         'r.kode_dana',
        //         'r.nama_dana',
        //         'r.kode_skpd',
        //         'r.nama_skpd',
        //         'r.pptk_id',
        //         'r.pokja_id',
        //         DB::raw('COALESCE(SUM(d.volume),0) as reg_sah_vol'),
        //         DB::raw('COALESCE(SUM(d.total),0) as reg_sah_nom')
        //     )
        //     ->groupBy(
        //         'r.id_rinci_sub_bl',
        //         'r.nama_komponen',
        //         'r.satuan',
        //         'r.volume',
        //         'r.harga_satuan',
        //         'r.kode_dana',
        //         'r.nama_dana',
        //         'r.kode_skpd',
        //         'r.nama_skpd',
        //         'r.pptk_id',
        //         'r.pokja_id'
        //     )
        //     ->get()
        //     ->map(function ($row) {
        //         $total_rencana = $row->volume * $row->harga_satuan;

        //         return [
        //             'id_rinci_sub_bl'   => $row->id_rinci_sub_bl,
        //             'nama_komponen'     => $row->nama_komponen,
        //             'satuan'            => $row->satuan,
        //             'volume'            => $row->volume,
        //             'harga_satuan'      => $row->harga_satuan,
        //             'reg_sah_vol'       => (int) $row->reg_sah_vol,
        //             'reg_sah_nom'       => (int) $row->reg_sah_nom,
        //             'sisa_vol'          => $row->volume - $row->reg_sah_vol,
        //             'sisa_nom'          => $total_rencana - $row->reg_sah_nom,
        //             'kode_dana'         => $row->kode_dana,
        //             'nama_dana'         => $row->nama_dana,
        //             'kode_skpd'         => $row->kode_skpd,
        //             'nama_skpd'         => $row->nama_skpd,
        //             'pptk_id'           => $row->pptk_id,
        //             'pokja_id'          => $row->pokja_id,
        //         ];
        //     });
        return response()->json($data);
    }

    public function programByDpa($versi)
    {
        return RincianRka::where('id_versi_anggaran', $versi)
            ->select('kode_program', 'nama_program')
            ->groupBy('kode_program', 'nama_program')
            ->orderBy('kode_program')
            ->get();
    }

    public function kegiatanByProgram($program)
    {
        return RincianRka::where('kode_program', $program)
            ->select('kode_giat', 'nama_giat')
            ->groupBy('kode_giat', 'nama_giat')
            ->orderBy('kode_giat')
            ->get();
    }

    public function subByKegiatan($kegiatan)
    {
        return RincianRka::where('kode_giat', $kegiatan)
            ->select('kode_sub_giat', 'nama_sub_giat')
            ->groupBy('kode_sub_giat', 'nama_sub_giat')
            ->orderBy('kode_sub_giat')
            ->get();
    }

    public function akunBySubKegiatan($subkegiatan)
    {
        return RincianRka::where('kode_sub_giat', $subkegiatan)
            ->select('kode_akun', 'nama_akun')
            ->groupBy('kode_akun', 'nama_akun')
            ->orderBy('kode_akun')
            ->get();
    }

    public function komponenByAkun($akun)
    {
        return RincianRka::where('kode_akun', $akun)
            ->select('id_rinci_sub_bl', 'nama_komponen')
            ->groupBy('id_rinci_sub_bl', 'nama_komponen')
            ->orderBy('id_rinci_sub_bl')
            ->get();
    }

    public function show($id)
    {
        $register = Register::with('detailBelanja.rincianRka')->findOrFail($id);

        // dd($register->detailBelanja);

        return view('a2.show', compact('register'));
    }

    public function index(Request $request)
    {
        $query = Register::query(); // ganti sesuai model kamu

        if ($request->filled('q')) {
            $q = strtolower($request->q);

            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(gen_no_reg) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(urai_rekbel) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(keperluan) LIKE ?', ["%{$q}%"]);
            });
        }

        if ($request->filled('tgl_dari')) {
            $query->whereDate('created_at', '>=', $request->tgl_dari);
        }

        if ($request->filled('tgl_sampai')) {
            $query->whereDate('created_at', '<=', $request->tgl_sampai);
        }

        $registers = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('a2.index', compact('registers'));
    }

    public function edit($id)
    {
        $register = Register::findOrFail($id);

        $versi = VersiAnggaran::all();
        $penerima = Penerima::orderBy('penerima')->get();
        $dpp = Dpp::all();

        $versipilihan = VersiAnggaran::where('nomor_anggaran',$register->no_dpa)->value('id_versi_anggaran');

        $program = RincianRka::where('id_versi_anggaran', $versipilihan)
            ->select('kode_program', 'nama_program')
            ->groupBy('kode_program', 'nama_program')
            ->orderBy('kode_program')
            ->get();

        $kegiatan = RincianRka::where('kode_program', $register->kd_prog)
            ->select('kode_giat', 'nama_giat')
            ->groupBy('kode_giat', 'nama_giat')
            ->orderBy('kode_giat')
            ->get();
            
        $subkegiatan = RincianRka::where('kode_giat', $register->kd_keg)
            ->select('kode_sub_giat', 'nama_sub_giat')
            ->groupBy('kode_sub_giat', 'nama_sub_giat')
            ->orderBy('kode_sub_giat')
            ->get();
        
        $akun = RincianRka::where('kode_sub_giat', $register->kd_subkeg)
            ->select('kode_akun', 'nama_akun')
            ->groupBy('kode_akun', 'nama_akun')
            ->orderBy('kode_akun')
            ->get();

        $komponen = RincianRka::from('rincian_rka as r')
            ->leftJoin('detail_belanja as d', 'd.id_rinci_sub_bl', '=', 'r.id_rinci_sub_bl')
            ->where('r.id_versi_anggaran', $versipilihan)
            ->where('r.kode_program', $register->kd_prog)
            ->where('r.kode_giat', $register->kd_keg)
            ->where('r.kode_sub_giat', $register->kd_subkeg)
            ->where('r.kode_akun', $register->kd_rekbel)
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
                // 'd.volume',
                DB::raw('COALESCE(SUM(d.volume),0) as reg_sah_vol'),
                DB::raw('COALESCE(SUM(d.total_dibayar),0) as reg_sah_nom')
            )
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
            ->get()
            ->map(function ($row) {
                $total_rencana = $row->volume * $row->harga_satuan;

                return [
                    'id_rinci_sub_bl'   => $row->id_rinci_sub_bl,
                    'nama_komponen'     => $row->nama_komponen,
                    'satuan'            => $row->satuan,
                    'volume'            => $row->volume,
                    'harga_satuan'      => $row->harga_satuan,
                    'reg_sah_vol'       => (int) $row->reg_sah_vol,
                    'reg_sah_nom'       => (int) $row->reg_sah_nom,
                    'sisa_vol'          => $row->volume - $row->reg_sah_vol,
                    'sisa_nom'          => $total_rencana - $row->reg_sah_nom,
                    'kode_dana'         => $row->kode_dana,
                    'nama_dana'         => $row->nama_dana,
                    'kode_skpd'         => $row->kode_skpd,
                    'nama_skpd'         => $row->nama_skpd,
                    'pptk_id'           => $row->pptk_id,
                    'pokja_id'          => $row->pokja_id,
                ];
            });
        // dd($komponen);
        return view('a2.edit', compact(
            'register',
            'versi',
            'penerima',
            'program',
            'kegiatan',
            'subkegiatan',
            'akun',
            'dpp',
            'komponen'
        ));
    }

    public function update(Request $request, $id)
    {
        $register = Register::findOrFail($id);

        $register->update($request->all());

        return redirect()
            ->route('a2.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        try {
            $register = Register::findOrFail($id);
            $register->detailBelanja()->delete();
            $register->delete();

            return redirect()->route('a2.index')
                ->with('success', 'Data berhasil dihapus');

        } catch (\Throwable $e) {
            return back()->with('error', 'Data gagal dihapus');
        }
    }
}
