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
use App\Models\Umk;
use App\Models\Pptk;
use App\Models\Pokja;
use App\Models\TarifPpn;
use Illuminate\Support\Facades\Log;


class A2Controller extends Controller
{
    public function create()
    {
        $user = auth()->user();

        $versi = VersiAnggaran::all();

        $penerima = Penerima::orderBy('penerima')->get();

        $dpp = Dpp::all();
        $ppn = TarifPpn::find(1);
        
        $tahun = now()->year;

        $umk = Umk::where('tahun', $tahun)->value('nominal');

        return view('a2.create', compact(
            'versi',
            'penerima',
            'dpp',
            'ppn',
            'umk'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        DB::beginTransaction();

        try {
            // ================= VALIDASI =================

            $request->validate([
                'versi' => 'required',
                'program' => 'required',
                'nama_program' => 'required',
                'kegiatan' => 'required',
                'nama_giat' => 'required',
                'sub_kegiatan' => 'required',
                'nama_sub_giat' => 'required',
                'kode_akun' => 'required',
                'nama_akun' => 'required',
                'bruto' => 'required',
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

            $versiTerbaru = DB::table('versi_anggaran')
                ->max('id');

            // ================= CEK SALDO ANGGARAN =================

            foreach ($request->riil as $row) {
                if (empty($row['vol']) || empty($row['harga'])) {
                    continue;
                }

                $vol             = (int) $row['vol'];
                $harga           = (int) str_replace('.', '', $row['harga']);
                $nominalDiajukan = $vol * $harga;

                // Total yang sudah terealisasi untuk komponen ini
                $totalTerealisasi = DB::table('detail_belanja')
                    ->where('id_rinci_sub_bl', $row['id_rinci_sub_bl'])
                    ->where('kd_subkeg', $request->sub_kegiatan)
                    ->sum('total_dibayar');
                

                // Pagu anggaran komponen dari tabel rinci_sub_bl
                // ================= PAGU ANGGARAN =================
                $anggaranItem = DB::table('rincian_rka')
                    ->where('versi_anggaran_id', $versiTerbaru)
                    ->where('id_rinci_sub_bl', $row['id_rinci_sub_bl'])
                    ->where('kode_sub_giat', $request->sub_kegiatan)
                    ->value('total_harga'); // pastikan nama kolom sesuai

                if (is_null($anggaranItem)) {
                    throw new \Exception(
                        "Data anggaran tidak ditemukan (versi: {$versiTerbaru}, rincian: {$row['id_rinci_sub_bl']})"
                    );
                }

                $sisaSaldo = (int) $anggaranItem - (int) $totalTerealisasi;

                if ($nominalDiajukan > $sisaSaldo) {
                    $namaKomponen = $row['nama_komponen'] ?? "ID {$row['id_rinci_sub_bl']}";
                    throw new \Exception(
                        "Saldo anggaran tidak mencukupi untuk komponen \"{$namaKomponen}\". " .
                        "Diajukan: Rp " . number_format($nominalDiajukan, 0, ',', '.') .
                        ", Sisa saldo: Rp " . number_format($sisaSaldo, 0, ',', '.') . "."
                    );
                }
            }

            // ================= NOMOR REGISTER =================

            $lastNumber = DB::table('register')
                ->selectRaw("MAX(CAST(SUBSTRING_INDEX(gen_no_reg,'/',1) AS UNSIGNED)) as last_number")
                ->value('last_number') ?? 0;

            $nomorUrut = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $tahun     = now()->year;
            $jenis     = ($request->tata_usaha == 'LS' ? 'LS/' : '') . $request->transaksi;
            $sdana     = $riilValid['kode_dana'] == '1.1.01'             ? 'PAD'    :
                        ($riilValid['kode_dana'] == '1.2.01.08'          ? 'DAU'    :
                        ($riilValid['kode_dana'] == '1.4.01'             ? 'SILPA'  :
                        ($riilValid['kode_dana'] == '2.2.01.07.01.0004'  ? 'DBHCHT' : '')));

            $nomorSurat = "{$nomorUrut}/BP/{$jenis}/$sdana/{$request->sub_kegiatan}/DISKOMINFO/{$tahun}";

            $pejabat = MasterPejabat::where('kode_skpd', $riilValid['kode_skpd'])->first();
            $pptk    = Pptk::findOrFail($riilValid['pptk_id']);
            $pokja   = Pokja::findOrFail($riilValid['pokja_id']);

            $pajak   = $request->input('pajak', []);
            $kode    = $pajak['kode']    ?? [];
            $jenis   = $pajak['jenis']   ?? [];
            $nominal = $pajak['nominal'] ?? [];
            
            // ================= HEADER =================

            $register = Register::create([
                'gen_no_reg'        => $nomorSurat,
                'versi_anggaran_id' => $request->versi,
                'no_dpa'            => $request->no_dpa,
                'tanggal'           => $request->tanggal,
                'kd_prog'           => $request->program,
                'kd_keg'            => $request->kegiatan,
                'kd_subkeg'         => $request->sub_kegiatan,
                'urai_prog'         => $request->nama_program,
                'urai_keg'          => $request->nama_giat,
                'urai_subkeg'       => $request->nama_sub_giat,
                'kd_rekbel'         => $request->kode_akun,
                'urai_rekbel'       => $request->nama_akun,
                'jenis_tu'          => $request->tata_usaha,
                'jenis_a2'          => $request->jenis_a2,
                'j_transaksi'       => $request->transaksi,
                'npwp_penerima'     => $request->npwp,
                'nom_bruto'         => (int) str_replace('.', '', $request->bruto),
                't_pajak'           => (int) str_replace('.', '', $request->pajakPotong),
                't_iwp'             => (int) str_replace('.', '', $request->iwpTotal),
                't_potongan'        => (int) str_replace('.', '', $request->totalPotongan),
                'nom_netto'         => (int) str_replace('.', '', $request->nom_netto),
                'nama_penerima'     => $request->nama_penerima,
                'bank_penerima'     => $request->bank_penerima,
                'norek_penerima'    => $request->norek_penerima,
                'alamat_penerima'   => $request->alamat_penerima,
                'keperluan'         => $request->keperluan,
                'bruto_terbilang'   => $request->bruto_terbilang,
                'netto_terbilang'   => $request->netto_terbilang,
                'opd_id'            => $riilValid['opd_id'],
                'kode_skpd'         => $riilValid['kode_skpd'],
                'nama_skpd'         => $riilValid['nama_skpd'],
                'unit_id'           => $riilValid['unit_id'],
                'nama_pa'           => $pejabat->nama_pa,
                'nip_pa'            => $pejabat->nip_pa,
                'nama_pptk'         => $pptk->nama_pptk,
                'nip_pptk'          => $pptk->nip,
                'nama_bendahara'    => $pejabat->nama_bendahara,
                'nip_bendahara'     => $pejabat->nip_bendahara,
                'verifikator1'      => $pejabat->nama_ppk,
                'verifikator2'      => $pokja->nama_kapokja,
                'jpajak_1'          => $jenis[0]   ?? null,
                'kd_pot1'           => $kode[0]    ?? null,
                'id_bill1'          => '',
                'nom_pajak1'        => (int) str_replace('.', '', $nominal[0] ?? 0),
                'jpajak_2'          => $jenis[1]   ?? null,
                'kd_pot2'           => $kode[1]    ?? null,
                'id_bill2'          => '',
                'nom_pajak2'        => (int) str_replace('.', '', $nominal[1] ?? 0),
            ]);

            // ================= DETAIL RIIL =================

            $detilData = [];

            $tahun = now()->year;

            $umk = Umk::where('tahun', $tahun)->value('nominal');

            if (!$umk) {
                throw new \Exception("UMK tahun {$tahun} belum disetting");
            }


            foreach ($request->riil as $row) {
                if (empty($row['vol']) || empty($row['harga'])) {
                    continue;
                }

                $vol   = (int) $row['vol'];
                $harga = (int) str_replace('.', '', $row['harga']);

                $ppn = ($row['ppn'] ?? false) ? $vol * $harga * $request->ppn / 100 : 0;
                $iwp = ($row['iwp'] ?? false) ? (int) ceil(max($vol * $harga,$umk) * 1 / 100) : 0;

                $total_dpp     = ($vol * $harga) - $iwp;
                $total_dibayar = $total_dpp + $ppn + $iwp;

                $detilData[] = [
                    'id_reg'          => $register->id_reg,
                    'no_reg'          => $register->gen_no_reg,
                    'kd_subkeg'       => $register->kd_subkeg,
                    'kd_rek'          => $register->kd_rekbel,
                    'id_rinci_sub_bl' => $row['id_rinci_sub_bl'],
                    'volume'          => $vol,
                    'harga_riil'      => $harga,
                    'total_dpp'       => $total_dpp,
                    'ppn'             => $ppn,
                    'iwp'             => $iwp,
                    'total_dibayar'   => $total_dibayar,
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
        $register = Register::with('detailBelanja.rincianRka')->findOrFail($id);

        $nomorsurat = strstr($register->gen_no_reg, "/BP/");
        $nomorsurat = str_replace("/BP/", "", $nomorsurat);

        $dpp1 = Dpp::where('kode_potongan', $register->kd_pot1)->value('jenis_potongan');
        $dpp2 = Dpp::where('kode_potongan', $register->kd_pot2)->value('jenis_potongan');

        return view('a2.print', compact('register', 'nomorsurat', 'dpp1', 'dpp2'));
    }

    public function filterRincian(Request $request)
    {
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
            ->where('r.versi_anggaran_id', $request->input('versi'))
            ->groupBy(
                'r.id_rinci_sub_bl',
                'r.nama_komponen',
                'r.satuan',
                'r.volume',
                'r.harga_satuan',
                'r.kode_dana',
                'r.nama_dana',
                'r.opd_id',
                'r.unit_id',
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
                'r.opd_id',
                'r.unit_id',
                'r.kode_skpd',
                'r.nama_skpd',
                'r.pptk_id',
                'r.pokja_id',
                DB::raw('COALESCE(SUM(d.volume), 0) as reg_vol'),
                DB::raw('COALESCE(SUM(d.total_dibayar), 0) as reg_nom')
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
                    'reg_vol'           => $row->reg_vol,
                    'reg_nom'           => $row->reg_nom,
                    'sisa_vol'          => $row->volume - $row->reg_vol,
                    'sisa_nom'          => $total_rencana - $row->reg_nom,
                    'kode_dana'         => $row->kode_dana,
                    'nama_dana'         => $row->nama_dana,
                    'opd_id'            => $row->opd_id,
                    'unit_id'           => $row->unit_id,
                    'kode_skpd'         => $row->kode_skpd,
                    'nama_skpd'         => $row->nama_skpd,
                    'pptk_id'           => $row->pptk_id,
                    'pokja_id'          => $row->pokja_id,
                ];
            });
        return response()->json($data);
    }

    public function programByDpa($versi)
    {
        $user = auth()->user();

        return RincianRka::where('versi_anggaran_id', $versi)
            ->where('opd_id', $user->opd_id)
            ->where('unit_id', $user->unit_id)
            ->select('kode_program', 'nama_program')
            ->groupBy('kode_program', 'nama_program')
            ->orderBy('kode_program')
            ->get();
    }

    public function kegiatanByProgram($program)
    {
        $user = auth()->user();

        return RincianRka::where('kode_program', $program)
            ->where('opd_id', $user->opd_id)
            ->where('unit_id', $user->unit_id)
            ->select('kode_giat', 'nama_giat')
            ->groupBy('kode_giat', 'nama_giat')
            ->orderBy('kode_giat')
            ->get();
    }

    public function subByKegiatan($kegiatan)
    {
        $user = auth()->user();
        
        return RincianRka::where('kode_giat', $kegiatan)
            ->where('opd_id', $user->opd_id)
            ->where('unit_id', $user->unit_id)
            ->select('kode_sub_giat', 'nama_sub_giat')
            ->groupBy('kode_sub_giat', 'nama_sub_giat')
            ->orderBy('kode_sub_giat')
            ->get();
    }

    public function akunBySubKegiatan($subkegiatan)
    {
        $user = auth()->user();
        
        return RincianRka::where('kode_sub_giat', $subkegiatan)
            ->where('opd_id', $user->opd_id)
            ->where('unit_id', $user->unit_id)
            ->select('kode_akun', 'nama_akun')
            ->groupBy('kode_akun', 'nama_akun')
            ->orderBy('kode_akun')
            ->get();
    }

    public function komponenByAkun($akun)
    {
        $user = auth()->user();
        
        return RincianRka::where('kode_akun', $akun)
            ->where('opd_id', $user->opd_id)
            ->where('unit_id', $user->unit_id)
            ->select('id_rinci_sub_bl', 'nama_komponen')
            ->groupBy('id_rinci_sub_bl', 'nama_komponen')
            ->orderBy('id_rinci_sub_bl')
            ->get();
    }

    public function show($id)
    {
        $register = Register::with('detailBelanja.rincianRka')->findOrFail($id);

        return view('a2.show', compact('register'));
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Register::query()->where('opd_id', $user->opd_id)
            ->where('unit_id', $user->unit_id);

        // ── Filter global (q) ──────────────────────────────────────────────
        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->whereRaw('LOWER(gen_no_reg) LIKE ?',  ["%{$q}%"])
                    ->orWhereRaw('LOWER(urai_rekbel) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(keperluan) LIKE ?',   ["%{$q}%"]);
            });
        }

        // ── Filter tanggal ─────────────────────────────────────────────────
        if ($request->filled('tgl_dari')) {
            $query->whereDate('created_at', '>=', $request->tgl_dari);
        }

        if ($request->filled('tgl_sampai')) {
            $query->whereDate('created_at', '<=', $request->tgl_sampai);
        }

        // ── Filter per kolom ───────────────────────────────────────────────
        if ($request->filled('f_no_reg')) {
            $query->whereRaw('LOWER(gen_no_reg) LIKE ?', ['%' . strtolower($request->f_no_reg) . '%']);
        }

        if ($request->filled('f_subkeg')) {
            $query->whereRaw('LOWER(urai_subkeg) LIKE ?', ['%' . strtolower($request->f_subkeg) . '%']);
        }

        if ($request->filled('f_rekbel')) {
            $query->whereRaw('LOWER(urai_rekbel) LIKE ?', ['%' . strtolower($request->f_rekbel) . '%']);
        }

        if ($request->filled('f_keperluan')) {
            $query->whereRaw('LOWER(keperluan) LIKE ?', ['%' . strtolower($request->f_keperluan) . '%']);
        }

        if ($request->filled('f_nominal')) {
            // Hapus titik pemisah ribuan sebelum dicari
            $nominal = str_replace('.', '', $request->f_nominal);
            $query->whereRaw('CAST(nom_bruto AS TEXT) LIKE ?', ["%{$nominal}%"]);
        }

        // ── Sort ───────────────────────────────────────────────────────────
        $allowedSorts = ['gen_no_reg', 'urai_subkeg', 'urai_rekbel', 'keperluan', 'nom_bruto', 'created_at'];
        $sort         = in_array($request->sort, $allowedSorts) ? $request->sort : 'created_at';
        $order        = $request->order === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sort, $order);

        // ── Paginate ───────────────────────────────────────────────────────
        $registers = $query->paginate(10)->withQueryString();

        return view('a2.index', compact('registers'));
    }

    public function edit($id)
    {
        $register = Register::findOrFail($id);

        $versi = VersiAnggaran::all();
        $penerima = Penerima::orderBy('penerima')->get();
        $dpp = Dpp::all();
        $ppn = TarifPpn::find(1);

        $versipilihan = VersiAnggaran::where('nomor_anggaran', $register->no_dpa)->value('id');

        $program = RincianRka::where('versi_anggaran_id', $versipilihan)
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

        $b = DB::table('register as r')
            ->join('detail_belanja as db', 'r.id_reg', '=', 'db.id_reg')
            ->select(
                'r.id_reg',
                'r.kd_prog',
                'r.kd_keg',
                'r.kd_subkeg',
                'r.kd_rekbel',
                'db.id_rinci_sub_bl',
                'db.volume',
                'db.harga_riil',
                'db.total_dibayar',
                'db.ppn',
                'db.iwp'
            )
            ->where('r.id_reg', $id);

        $komponen = DB::table('rincian_rka as r')

            ->leftJoin('register as reg', function ($join) {
                $join->on('reg.kd_prog', '=', 'r.kode_program')
                    ->on('reg.kd_keg', '=', 'r.kode_giat')
                    ->on('reg.kd_subkeg', '=', 'r.kode_sub_giat')
                    ->on('reg.kd_rekbel', '=', 'r.kode_akun');
            })

            ->leftJoin('detail_belanja as d', function ($join) {
                $join->on('d.id_reg', '=', 'reg.id_reg')
                    ->on('d.id_rinci_sub_bl', '=', 'r.id_rinci_sub_bl');
            })

            ->leftJoinSub($b, 'b', function ($join) {
                $join->on('b.kd_prog', '=', 'r.kode_program')
                    ->on('b.kd_keg', '=', 'r.kode_giat')
                    ->on('b.kd_subkeg', '=', 'r.kode_sub_giat')
                    ->on('b.kd_rekbel', '=', 'r.kode_akun')
                    ->on('b.id_rinci_sub_bl', '=', 'r.id_rinci_sub_bl');
            })

            ->where('r.kode_giat', $register->kd_keg)
            ->where('r.kode_sub_giat', $register->kd_subkeg)
            ->where('r.kode_akun', $register->kd_rekbel)
            ->where('r.versi_anggaran_id', $versipilihan)

            ->groupBy(
                'r.kode_program',
                'r.kode_giat',
                'r.kode_sub_giat',
                'r.kode_akun',
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
                'b.id_reg',
                'b.volume',
                'b.harga_riil',
                'b.total_dibayar',
                'b.ppn',
                'b.iwp'
            )

            ->selectRaw('
                r.kode_program,
                r.kode_giat,
                r.kode_sub_giat,
                r.kode_akun,
                r.id_rinci_sub_bl,
                r.nama_komponen,
                r.satuan,
                r.volume,
                r.harga_satuan,
                r.kode_dana,
                r.nama_dana,
                r.kode_skpd,
                r.nama_skpd,
                r.pptk_id,
                r.pokja_id,
                COALESCE(SUM(d.volume),0) as reg_vol,
                COALESCE(SUM(d.total_dibayar),0) as reg_nom,
                b.id_reg,
                b.volume as volume_input,
                b.harga_riil,
                b.total_dibayar as total_input,
                b.ppn,
                b.iwp
            ')
            ->get()
            ->map(function ($row) {
                $total_rencana = $row->volume * $row->harga_satuan;

                return [
                    'id_rinci_sub_bl'   => $row->id_rinci_sub_bl,
                    'nama_komponen'     => $row->nama_komponen,
                    'satuan'            => $row->satuan,
                    'volume'            => $row->volume,
                    'harga_satuan'      => $row->harga_satuan,
                    'reg_vol'           => $row->reg_vol,
                    'reg_nom'           => $row->reg_nom,
                    'sisa_vol'          => $row->volume - $row->reg_vol,
                    'sisa_nom'          => $total_rencana - $row->reg_nom,
                    'kode_dana'         => $row->kode_dana,
                    'nama_dana'         => $row->nama_dana,
                    'kode_skpd'         => $row->kode_skpd,
                    'nama_skpd'         => $row->nama_skpd,
                    'pptk_id'           => $row->pptk_id,
                    'pokja_id'          => $row->pokja_id,
                    'volume_input'      => $row->volume_input,
                    'harga_riil'        => $row->harga_riil,
                    'total_input'       => $row->total_input,
                    'ppn'               => $row->ppn,
                    'iwp'               => $row->iwp,
                ];
            });

        return view('a2.edit', compact(
            'register',
            'versi',
            'penerima',
            'program',
            'kegiatan',
            'subkegiatan',
            'akun',
            'dpp',
            'komponen',
            'ppn'
        ));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $register = Register::findOrFail($id);

            // ================= VALIDASI =================
            $request->validate([
                'versi' => 'required',
                'program' => 'required',
                'nama_program' => 'required',
                'kegiatan' => 'required',
                'nama_giat' => 'required',
                'sub_kegiatan' => 'required',
                'nama_sub_giat' => 'required',
                'kode_akun' => 'required',
                'nama_akun' => 'required',
                'bruto' => 'required',
                'nom_netto' => 'required',
                'riil' => 'required|array',
                'nama_penerima' => 'required',
                'bank_penerima' => 'required',
                'norek_penerima' => 'required',
            ]);

            // ================= CEK DATA RIIL =================
            $riilValid = collect($request->riil)
                ->first(function ($row) {
                    return
                        !empty($row['vol']) &&
                        !empty($row['harga']) &&
                        (int)$row['vol'] > 0 &&
                        (int)str_replace('.', '', $row['harga']) > 0;
                });

            if (!$riilValid) {
                throw new \Exception('Tidak ada data riil yang memiliki volume dan harga');
            }

            $pejabat = MasterPejabat::where('kode_skpd', $riilValid['kode_skpd'])->first();
            $pptk = Pptk::findOrFail($riilValid['pptk_id']);
            $pokja = Pokja::findOrFail($riilValid['pokja_id']);

            // ================= PAJAK =================
            $pajak = $request->input('pajak', []);

            $kode   = $pajak['kode'] ?? [];
            $jenis  = $pajak['jenis'] ?? [];
            $nominal = $pajak['nominal'] ?? [];

            // ================= UPDATE HEADER =================
            $register->update([
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
                'nom_bruto'   => (int)str_replace('.', '', $request->bruto),
                't_pajak'     => (int)str_replace('.', '', $request->pajakPotong),
                't_iwp'     => (int) str_replace('.', '', $request->iwpTotal),
                't_potongan'     => (int) str_replace('.', '', $request->totalPotongan),
                'nom_netto'   => (int)str_replace('.', '', $request->nom_netto),
                'nama_penerima' => $request->nama_penerima,
                'bank_penerima' => $request->bank_penerima,
                'norek_penerima' => $request->norek_penerima,
                'alamat_penerima' => $request->alamat_penerima,
                'keperluan' => $request->keperluan,
                'bruto_terbilang' => $request->bruto_terbilang,
                'netto_terbilang' => $request->netto_terbilang,
                'kode_skpd' => $riilValid['kode_skpd'],
                'nama_skpd' => $riilValid['nama_skpd'],
                'nama_pa'   => $pejabat->nama_pa,
                'nip_pa'    => $pejabat->nip_pa,
                'nama_pptk' => $pptk->nama_pptk,
                'nip_pptk'  => $pptk->nip,
                'nama_bendahara' => $pejabat->nama_bendahara,
                'nip_bendahara' => $pejabat->nip_bendahara,
                'verifikator1'  => $pejabat->nama_ppk,
                'verifikator2'  => $pokja->nama_kapokja,
                'jpajak_1'   => $jenis[0] ?? null,
                'kd_pot1'    => $kode[0] ?? null,
                'nom_pajak1' => (int)str_replace('.', '', $nominal[0] ?? 0),
                'jpajak_2'   => $jenis[1] ?? null,
                'kd_pot2'    => $kode[1] ?? null,
                'nom_pajak2' => (int)str_replace('.', '', $nominal[1] ?? 0),
            ]);

            // ================= HAPUS DETAIL LAMA =================
            DetailBelanja::where('id_reg', $register->id_reg)->delete();

            // ================= INSERT DETAIL BARU =================
            $detilData = [];

            foreach ($request->riil as $row) {

                if (empty($row['vol']) || empty($row['harga'])) {
                    continue;
                }

                $vol   = (int)$row['vol'];
                $harga = (int)str_replace('.', '', $row['harga']);

                $ppn = ($row['ppn'] ?? false) ? $vol * $harga * $request->ppn / 100 : 0;

                $iwp = ($row['iwp'] ?? false) ? $vol * $harga *  1 / 100 : 0;

                $total_dpp = ($vol * $harga) - $iwp;

                $total_dibayar = $total_dpp + $ppn + $iwp;

                $detilData[] = [
                    'id_reg'          => $register->id_reg,
                    'no_reg'          => $register->gen_no_reg,
                    'kd_subkeg'       => $register->kd_subkeg,
                    'kd_rek'          => $register->kd_rekbel,
                    'id_rinci_sub_bl' => $row['id_rinci_sub_bl'],
                    'volume'          => $vol,
                    'harga_riil'      => $harga,
                    'total_dpp'       => $total_dpp,
                    'ppn'             => $ppn,
                    'iwp'             => $iwp,
                    'total_dibayar'   => $total_dibayar,
                ];
            }

            if (empty($detilData)) {
                throw new \Exception('Detail riil kosong');
            }

            DetailBelanja::insert($detilData);

            DB::commit();

            return redirect()
                ->route('a2.show', $register->id_reg)
                ->with('success', 'Data berhasil diperbarui');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Gagal update A2', [
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            return back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
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
