@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100 dark:bg-slate-900 p-3"
     x-data="a2Form()">

    {{-- ERROR ALERT (dari server / backend) --}}
    @if ($errors->any())
        <div class="mb-3 rounded-lg px-4 py-2 text-xs bg-red-50 border border-red-300 text-red-700 dark:bg-red-500/10 dark:border-red-500/30 dark:text-red-400">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ERROR ALERT SALDO (dari frontend / JS) --}}
    <div id="saldo-error-alert" style="display:none"
        class="mb-3 rounded-lg px-4 py-2 text-xs bg-red-50 border border-red-300 text-red-700 dark:bg-red-500/10 dark:border-red-500/30 dark:text-red-400">
    </div>

    <form x-ref="formA2" id="form-a2" method="POST" action="{{ route('a2.store') }}"
        class="space-y-3" @submit.prevent="handleBeforeConfirm()">
        @csrf
        <input type="hidden" name="ppn" value="{{ $ppn->tarif }}">
        <input type="hidden" name="umk" value="{{ $umk }}">

        {{-- ── HEADER BAR ── --}}
        <div class="bg-blue-800 dark:bg-slate-900 text-white px-4 py-2 rounded-lg shadow flex justify-between items-center border border-transparent dark:border-blue-500/30">
            <h1 class="text-xs font-bold uppercase tracking-wider">
                Register A2 — Bukti Pengeluaran Bidang Informatika {{ date('Y') }}
            </h1>
            <button type="submit" id="btn-save"
                class="bg-white text-blue-800 px-3 py-1 rounded text-xs font-bold hover:bg-blue-50 transition-colors">
                Simpan Data
            </button>
        </div>

        {{-- ── TATA USAHA / JENIS / TRANSAKSI ── --}}
        <div class="bg-white border border-slate-200 rounded-lg dark:bg-slate-800 dark:border-slate-700/60 p-3 shadow-sm">
            <div class="grid grid-cols-3 gap-3">
                {{-- Tata Usaha --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Tata Usaha</label>
                    <select name="tata_usaha"
                        class="w-full border border-slate-300 rounded px-2 py-1 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200">
                        <option value="GU" {{ old('tata_usaha') == 'GU' ? 'selected' : '' }}>Ganti Uang (GU)</option>
                        <option value="LS" {{ old('tata_usaha') == 'LS' ? 'selected' : '' }}>Langsung (LS)</option>
                    </select>
                </div>
                {{-- Jenis A2 --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Jenis A2</label>
                    <select name="jenis_a2"
                        class="w-full border border-slate-300 rounded px-2 py-1 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200">
                        <option value="Non"   {{ old('jenis_a2') == 'Non'   ? 'selected' : '' }}>Non</option>
                        <option value="Cetak" {{ old('jenis_a2') == 'Cetak' ? 'selected' : '' }}>Cetak</option>
                    </select>
                </div>
                {{-- Transaksi --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Transaksi</label>
                    <select name="transaksi"
                        class="w-full border border-slate-300 rounded px-2 py-1 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200">
                        <option value="BANK"  {{ old('transaksi') == 'BANK'  ? 'selected' : '' }}>BANK</option>
                        <option value="TUNAI" {{ old('transaksi') == 'TUNAI' ? 'selected' : '' }}>TUNAI</option>
                        <option value="KPPD"  {{ old('transaksi') == 'KPPD'  ? 'selected' : '' }}>KPPD</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ── DPA + PROGRAM / KEGIATAN ── --}}
        <div class="grid grid-cols-12 gap-3">

            {{-- DPA --}}
            <div class="col-span-4 bg-white border border-slate-200 rounded-lg p-3 shadow-sm">
                <p class="text-xs font-bold text-blue-700 uppercase border-b border-slate-100 dark:text-blue-400 dark:border-slate-700/60 pb-1 mb-2">
                    Pengaturan DPA
                </p>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Pilih DPA</label>
                        <select name="versi" id="versi"
                            class="w-full border border-slate-300 rounded px-2 py-1 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200"
                            required>
                            <option value="">-- Pilih --</option>
                            @foreach ($versi as $v)
                                <option value="{{ $v->id }}"
                                    {{ old('versi') == $v->id ? 'selected' : '' }}
                                    data-nomor="{{ $v->nomor_anggaran }}">
                                    {{ $v->versi_anggaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Nomor DPA</label>
                        <input type="text" readonly id="no_dpa" name="no_dpa" value="{{ old('no_dpa') }}"
                            class="w-full border border-slate-200 rounded px-2 py-1 text-xs bg-slate-100 text-slate-500 cursor-not-allowed dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400">
                    </div>
                </div>
            </div>

            {{-- Program / Kegiatan --}}
            <div class="col-span-8 bg-white border border-slate-200 rounded-lg p-3 shadow-sm">
                <p class="text-xs font-bold text-blue-700 uppercase border-b border-slate-100 dark:text-blue-400 dark:border-slate-700/60 pb-1 mb-2">
                    Program, Kegiatan &amp; Akun
                </p>
                <div class="grid grid-cols-2 gap-2">
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-slate-600">Program / Kegiatan</label>
                        <select name="program" id="program"
                            class="w-full border border-slate-300 rounded px-2 py-1 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200"
                            disabled>
                            <option value="">-- Pilih Program --</option>
                        </select>
                        <input type="hidden" name="nama_program" id="nama_program">
                        <select name="kegiatan" id="kegiatan"
                            class="w-full border border-slate-300 rounded px-2 py-1 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200"
                            disabled>
                            <option value="">-- Pilih Kegiatan --</option>
                        </select>
                        <input type="hidden" name="nama_giat" id="nama_giat">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-semibold text-slate-600">Sub Kegiatan — Akun Rekening</label>
                        <select name="sub_kegiatan" id="sub_kegiatan"
                            class="w-full border border-slate-300 rounded px-2 py-1 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200"
                            disabled>
                            <option value="">-- Pilih Sub Kegiatan --</option>
                        </select>
                        <select name="kode_akun" id="akun_rekening"
                            class="w-full border border-slate-300 rounded px-2 py-1 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-blue-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200"
                            disabled>
                            <option value="">-- Pilih Akun --</option>
                        </select>
                        <input type="hidden" name="nama_akun" id="nama_akun">
                        <input type="hidden" name="nama_sub_giat" id="nama_sub_giat">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── INFORMASI KEGIATAN + PENERIMA + POTONGAN PPh ── --}}
        <div class="grid grid-cols-12 gap-3">

            {{-- Informasi Kegiatan & Penerima --}}
            <div class="col-span-5 bg-white border border-slate-200 rounded-lg p-3 shadow-sm space-y-3">

                {{-- Kegiatan --}}
                <div>
                    <p class="text-xs font-bold text-green-700 uppercase border-b border-slate-100 dark:text-emerald-400 dark:border-slate-700/60 pb-1 mb-2">
                        Informasi Kegiatan
                    </p>
                    <div class="space-y-1.5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Tanggal</label>
                            <input type="date" name="tanggal"
                                class="w-full border border-slate-300 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-green-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Keperluan Pembayaran</label>
                            <textarea id="keperluan" name="keperluan" rows="2"
                                placeholder="Keperluan Pembayaran"
                                class="w-full border border-slate-300 rounded px-2 py-1 text-xs resize-none focus:outline-none focus:ring-1 focus:ring-green-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Penerima --}}
                <div>
                    <p class="text-xs font-bold text-green-700 uppercase border-b border-slate-100 dark:text-emerald-400 dark:border-slate-700/60 pb-1 mb-2">
                        Informasi Penerima
                    </p>
                    <div class="space-y-1.5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Nama Penerima</label>
                            <select name="penerima" id="penerima"
                                class="w-full border border-slate-300 rounded px-2 py-1 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-green-400"
                                onchange="isiDataPenerima()">
                                <option value=""></option>
                                @foreach ($penerima as $pn)
                                    <option value="{{ $pn->id }}"
                                        data-npwp="{{ $pn->npwp }}"
                                        data-bank="{{ $pn->bankpenerima }}"
                                        data-norek="{{ $pn->norek_penerima }}"
                                        data-nama="{{ $pn->penerima }}"
                                        data-alamat="{{ $pn->alamat }}">
                                        {{ $pn->penerima }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" id="nama_penerima" name="nama_penerima">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Bank</label>
                                <input type="text" id="bank_penerima" name="bank_penerima"
                                    class="w-full border border-slate-200 rounded px-2 py-1 text-xs bg-slate-50 focus:outline-none focus:ring-1 focus:ring-green-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">No. Rek / Kode Bayar</label>
                                <input type="text" id="norek_penerima" name="norek_penerima"
                                    class="w-full border border-slate-200 rounded px-2 py-1 text-xs bg-slate-50 focus:outline-none focus:ring-1 focus:ring-green-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">NPWP</label>
                            <input type="text" id="npwp" name="npwp"
                                class="w-full border border-slate-200 rounded px-2 py-1 text-xs bg-slate-50 focus:outline-none focus:ring-1 focus:ring-green-400 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200">
                        </div>
                        <input type="hidden" id="alamat_penerima" name="alamat_penerima">
                    </div>
                </div>
            </div>

            {{-- Hitung Potongan PPh --}}
            <div class="col-span-7 bg-white border border-slate-200 rounded-lg p-3 shadow-sm">
                <p class="text-xs font-bold text-orange-700 uppercase border-b border-slate-100 dark:text-orange-400 dark:border-slate-700/60 pb-1 mb-2">
                    Hitung Potongan PPh
                </p>

                {{-- Tabel Golongan --}}
                <table class="w-full text-xs border border-slate-200 mb-2">
                    <thead class="bg-yellow-700 text-white">
                        <tr>
                            <th class="border border-yellow-600 px-2 py-1 text-left font-semibold">Jenis Golongan</th>
                            <th class="border border-yellow-600 px-2 py-1 font-semibold">Vol</th>
                            <th class="border border-yellow-600 px-2 py-1 font-semibold">Besaran</th>
                            <th class="border border-yellow-600 px-2 py-1 font-semibold">Pajak</th>
                        </tr>
                    </thead>
                    <tbody class="bg-yellow-50 font-semibold">
                        <tr>
                            <td class="border border-yellow-100 px-2 py-1">Golongan IV</td>
                            <td class="border border-yellow-100 px-1 py-1">
                                <input type="number" id="vol_iv" oninput="hitungPajakManual()"
                                    class="w-full border border-slate-300 rounded px-1 py-0.5 text-xs text-center focus:outline-none focus:ring-1 focus:ring-yellow-400">
                            </td>
                            <td class="border border-yellow-100 px-1 py-1">
                                <input type="number" id="besaran_iv" oninput="hitungPajakManual()"
                                    class="w-full border border-slate-300 rounded px-1 py-0.5 text-xs text-center focus:outline-none focus:ring-1 focus:ring-yellow-400">
                            </td>
                            <td class="border border-yellow-100 px-2 py-1 text-right" id="pajak_iv">0</td>
                        </tr>
                        <tr>
                            <td class="border border-yellow-100 px-2 py-1">Golongan III</td>
                            <td class="border border-yellow-100 px-1 py-1">
                                <input type="number" id="vol_iii" oninput="hitungPajakManual()"
                                    class="w-full border border-slate-300 rounded px-1 py-0.5 text-xs text-center focus:outline-none focus:ring-1 focus:ring-yellow-400">
                            </td>
                            <td class="border border-yellow-100 px-1 py-1">
                                <input type="number" id="besaran_iii" oninput="hitungPajakManual()"
                                    class="w-full border border-slate-300 rounded px-1 py-0.5 text-xs text-center focus:outline-none focus:ring-1 focus:ring-yellow-400">
                            </td>
                            <td class="border border-yellow-100 px-2 py-1 text-right" id="pajak_iii">0</td>
                        </tr>
                        <tr>
                            <td class="border border-yellow-100 px-2 py-1">Pihak Lain</td>
                            <td class="border border-yellow-100 px-1 py-1">
                                <input type="number" id="vol_lain" oninput="hitungPajakManual()"
                                    class="w-full border border-slate-300 rounded px-1 py-0.5 text-xs text-center focus:outline-none focus:ring-1 focus:ring-yellow-400">
                            </td>
                            <td class="border border-yellow-100 px-1 py-1">
                                <input type="number" id="besaran_lain" oninput="hitungPajakManual()"
                                    class="w-full border border-slate-300 rounded px-1 py-0.5 text-xs text-center focus:outline-none focus:ring-1 focus:ring-yellow-400">
                            </td>
                            <td class="border border-yellow-100 px-2 py-1 text-right" id="pajak_lain">0</td>
                        </tr>
                    </tbody>
                </table>

                {{-- Tabel Potongan Pajak --}}
                <table class="w-full text-xs border border-slate-200" id="tabel_pajak">
                    <thead class="bg-red-700 text-white">
                        <tr>
                            <th class="border border-red-600 px-2 py-1 text-left font-semibold">Potongan Pajak</th>
                            <th class="border border-red-600 px-2 py-1 font-semibold">Nominal</th>
                            <th class="border border-red-600 px-2 py-1 font-semibold">Kode</th>
                            <th class="border border-red-600 px-2 py-1 font-semibold w-8">+</th>
                        </tr>
                    </thead>
                    <tbody id="body_pajak" class="bg-red-50 text-center">
                        <tr class="pajak-row">
                            <td class="border border-red-100 px-1 py-1">
                                <select name="pajak[kode][]"
                                    class="w-full border border-slate-300 rounded px-1 py-0.5 text-xs bg-white focus:outline-none focus:ring-1 focus:ring-red-400"
                                    onchange="hitungPajakBaris(this)">
                                    <option value="">-- Pilih Pajak --</option>
                                    @foreach ($dpp as $p)
                                        <option value="{{ $p->kode_potongan }}"
                                            data-jenis="{{ $p->jenis_pajak }}">
                                            {{ $p->jenis_potongan }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border border-red-100 px-1 py-1">
                                <input type="text" name="pajak[nominal][]" value="0" readonly
                                    class="w-full text-right text-xs bg-slate-100 border border-slate-200 rounded px-1 py-0.5 cursor-not-allowed">
                                <input type="hidden" name="pajak[jenis][]">
                            </td>
                            <td class="border border-red-100 px-2 py-1 kode-pajak text-slate-500">-</td>
                            <td class="border border-red-100 px-1 py-1">
                                <button type="button" onclick="tambahPajak()"
                                    class="bg-green-600 hover:bg-green-700 text-white w-6 h-6 rounded text-xs font-bold transition-colors">
                                    +
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- ── TOTAL DIBAYARKAN ── --}}
                <div class="mt-2 rounded-lg px-3 py-2 space-y-1.5 bg-blue-50 border border-blue-200 dark:bg-blue-500/10 dark:border-blue-500/20">
                    <div class="flex gap-2">

                        {{-- Bruto --}}
                        <div class="flex-1 bg-white border border-blue-200 rounded px-2 py-1">
                            <p class="text-[10px] text-slate-400 uppercase font-semibold leading-none mb-0.5">Bruto</p>
                            <input type="text" id="bruto" name="bruto" readonly
                                class="w-full text-right bg-transparent border-none text-xs font-bold text-slate-800 focus:outline-none">
                        </div>

                        {{-- Grup Potongan --}}
                        <div class="flex-1 bg-red-50 border border-red-200 rounded px-2 py-1 space-y-0.5">
                            <p class="text-[10px] font-semibold text-red-400 uppercase leading-none mb-0.5">Potongan</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-red-400">Pajak</span>
                                <input type="text" id="pajakPotong" name="pajakPotong" readonly
                                    class="w-28 text-right bg-transparent border-none text-xs font-semibold text-red-600 focus:outline-none">
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-orange-400">IWP (1%)</span>
                                <input type="text" id="iwpTotal" name="iwpTotal" readonly
                                    class="w-28 text-right bg-transparent border-none text-xs font-semibold text-orange-500 focus:outline-none">
                            </div>
                            <div class="flex justify-between items-center border-t border-red-200 pt-0.5">
                                <span class="text-xs font-bold text-red-700">Total</span>
                                <input type="text" id="totalPotongan" name="totalPotongan" readonly
                                    class="w-28 text-right bg-transparent border-none text-xs font-black text-red-700 focus:outline-none">
                            </div>
                        </div>

                        {{-- Netto --}}
                        <div class="flex-1 bg-green-50 border border-green-300 rounded px-2 py-1">
                            <p class="text-[10px] font-semibold text-green-600 uppercase leading-none mb-0.5">Netto</p>
                            <input type="text" id="netto" name="nom_netto" readonly
                                class="w-full text-right bg-transparent border-none text-xs font-black text-green-700 focus:outline-none">
                        </div>

                    </div>

                    {{-- Terbilang --}}
                    <div class="flex items-start gap-2">
                        <span class="text-[10px] text-slate-400 italic whitespace-nowrap pt-0.5">Terbilang:</span>
                        <textarea id="terbilang" rows="2" readonly name="netto_terbilang"
                            placeholder="Terbilang netto akan muncul di sini..."
                            class="flex-1 text-xs bg-white italic px-2 py-1 border border-blue-200 rounded text-slate-600 resize-none focus:outline-none leading-snug"></textarea>
                    </div>

                    <input type="hidden" name="bruto_terbilang" id="bruto_terbilang">
                </div>
            </div>
        </div>

        {{-- ── TABEL RINCIAN KOMPONEN (full width) ── --}}
        <div class="bg-white border border-slate-200 rounded-lg dark:bg-slate-800 dark:border-slate-700/60 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs leading-tight" style="min-width:800px">
                    <thead class="bg-slate-900 dark:bg-slate-950 text-white sticky top-0 text-center">
                        <tr>
                            <th rowspan="2" class="border border-slate-700 px-2 py-1 whitespace-nowrap">ID</th>
                            <th rowspan="2" class="border border-slate-700 px-2 py-1 whitespace-nowrap">Uraian Komponen</th>
                            <th rowspan="2" class="border border-slate-700 px-2 py-1 whitespace-nowrap">Satuan</th>
                            <th colspan="3" class="border border-blue-600 px-2 py-1 bg-blue-700">Rincian Anggaran</th>
                            <th colspan="5" class="border border-green-600 px-2 py-1 bg-green-700">Pengeluaran Riil</th>
                            <th colspan="4" class="border border-indigo-600 px-2 py-1 bg-indigo-700">Informasi Komponen</th>
                        </tr>
                        <tr>
                            {{-- Rincian Anggaran --}}
                            <th class="border border-blue-600 px-2 py-1 bg-blue-700">Vol</th>
                            <th class="border border-blue-600 px-2 py-1 bg-blue-700">Harga</th>
                            <th class="border border-blue-600 px-2 py-1 bg-blue-700">Total</th>
                            {{-- Riil --}}
                            <th class="border border-green-600 px-2 py-1 bg-green-700 min-w-[5rem]">Vol</th>
                            <th class="border border-green-600 px-2 py-1 bg-green-700">Harga</th>
                            <th class="border border-green-600 px-2 py-1 bg-green-700">PPN</th>
                            <th class="border border-green-600 px-2 py-1 bg-green-700">IWP</th>
                            <th class="border border-green-600 px-2 py-1 bg-green-700">Nominal</th>
                            {{-- Info --}}
                            <th class="border border-indigo-600 px-2 py-1 bg-indigo-700">Reg Vol</th>
                            <th class="border border-indigo-600 px-2 py-1 bg-indigo-700">Reg Nom</th>
                            <th class="border border-indigo-600 px-2 py-1 bg-indigo-700">Sisa Vol</th>
                            <th class="border border-indigo-600 px-2 py-1 bg-indigo-700">Sisa Nom</th>
                        </tr>
                    </thead>
                    <tbody id="tabelRincian" class="divide-y divide-slate-100 dark:divide-slate-700/60">
                        <tr>
                            <td colspan="15" class="text-center py-6 text-slate-400 text-xs italic">
                                Pilih Akun Rekening untuk memuat data rincian...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <input type="hidden" id="hasilPph" name="hasilPph">
        <input type="hidden" name="iwp_total" id="iwp_total_hidden">

    </form>

    {{-- ── MODAL KONFIRMASI ── --}}
    <div x-show="open" x-transition @click.self="open = false" style="display:none"
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div class="rounded-xl shadow-2xl w-96 p-6 bg-white border border-gray-200 dark:bg-slate-800 dark:border-slate-700">
            <h2 class="text-base font-semibold mb-2 text-slate-800 dark:text-slate-100">Konfirmasi Simpan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Yakin ingin menyimpan data A2 ini?</p>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" @click="open = false"
                    class="px-4 py-2 text-sm rounded-lg transition-colors bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-slate-200">
                    Batal
                </button>
                {{-- ✦ DIUBAH: panggil submitDenganCekSaldo() bukan $refs.formA2.submit() langsung --}}
                <button type="button" @click="submitDenganCekSaldo() && (open = false)"
                    class="px-4 py-2 text-sm bg-blue-700 hover:bg-blue-800 text-white rounded-lg shadow transition-colors">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>

</div>{{-- tutup x-data --}}
@endsection

@push('scripts')
<script>
    /* ─────────────────────────────────────────
     * TOM SELECT — Penerima
     * ───────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', function () {
        new TomSelect('#penerima', {
            create: false,
            allowEmptyOption: true,
            placeholder: 'Cari penerima...'
        });
    });

    /* ─────────────────────────────────────────
     * DPA / CASCADING SELECTS
     * ───────────────────────────────────────── */
    document.addEventListener('DOMContentLoaded', function () {

        function resetSelect(id, placeholder) {
            const el = document.getElementById(id);
            el.innerHTML = `<option value="">${placeholder}</option>`;
            el.disabled = true;
        }

        function setLoadingSelect(id, text = 'Memuat...') {
            const el = document.getElementById(id);
            el.innerHTML = `<option value="">${text}</option>`;
            el.disabled = true;
        }

        /* Versi / DPA */
        document.getElementById('versi').addEventListener('change', function () {
            const nomor = this.options[this.selectedIndex]?.dataset.nomor;
            document.getElementById('no_dpa').value = nomor ?? '';

            const versi = this.value;
            setLoadingSelect('program', 'Memuat Program...');
            resetSelect('kegiatan', '-- Pilih Kegiatan --');
            resetSelect('sub_kegiatan', '-- Pilih Sub Kegiatan --');
            resetSelect('akun_rekening', '-- Pilih Akun --');

            if (!versi) return;

            fetch(`/a2/program-by-dpa/${versi}`)
                .then(res => { if (!res.ok) throw new Error('Server error'); return res.json(); })
                .then(data => {
                    const program = document.getElementById('program');
                    program.innerHTML = `<option value="">-- Pilih Program --</option>`;
                    program.disabled = false;
                    data.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.kode_program;
                        opt.textContent = p.nama_program;
                        program.appendChild(opt);
                    });
                })
                .catch(() => alert('Gagal memuat data program'));
        });

        /* Program */
        document.getElementById('program').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('nama_program').value = selected ? selected.textContent.trim() : '';

            const programId = this.value;
            setLoadingSelect('kegiatan', 'Memuat Kegiatan...');
            resetSelect('sub_kegiatan', '-- Pilih Sub Kegiatan --');
            resetSelect('akun_rekening', '-- Pilih Akun --');

            if (!programId) return;

            fetch(`/a2/kegiatan-by-program/${programId}`)
                .then(res => { if (!res.ok) throw new Error('Server error'); return res.json(); })
                .then(data => {
                    const kegiatan = document.getElementById('kegiatan');
                    kegiatan.innerHTML = `<option value="">-- Pilih Kegiatan --</option>`;
                    kegiatan.disabled = false;
                    data.forEach(k => {
                        const opt = document.createElement('option');
                        opt.value = k.kode_giat;
                        opt.textContent = k.nama_giat;
                        kegiatan.appendChild(opt);
                    });
                })
                .catch(() => alert('Gagal memuat data kegiatan'));
        });

        /* Kegiatan */
        document.getElementById('kegiatan').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('nama_giat').value = selected ? selected.textContent.trim() : '';

            const kegiatanId = this.value;
            setLoadingSelect('sub_kegiatan', 'Memuat Sub Kegiatan...');
            resetSelect('akun_rekening', '-- Pilih Akun --');

            if (!kegiatanId) return;

            fetch(`/a2/subkegiatan-by-kegiatan/${kegiatanId}`)
                .then(res => { if (!res.ok) throw new Error('Server error'); return res.json(); })
                .then(data => {
                    const sub = document.getElementById('sub_kegiatan');
                    sub.innerHTML = `<option value="">-- Pilih Sub Kegiatan --</option>`;
                    sub.disabled = false;
                    data.forEach(s => {
                        const opt = document.createElement('option');
                        opt.value = s.kode_sub_giat;
                        opt.textContent = s.nama_sub_giat;
                        sub.appendChild(opt);
                    });
                })
                .catch(() => alert('Gagal memuat data sub kegiatan'));
        });

        /* Sub Kegiatan */
        document.getElementById('sub_kegiatan').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('nama_sub_giat').value = selected ? selected.textContent.trim() : '';

            const sub = this.value;
            setLoadingSelect('akun_rekening', 'Memuat Akun...');

            if (!sub) return;

            fetch(`/a2/akun-by-subkegiatan/${sub}`)
                .then(res => { if (!res.ok) throw new Error('Server error'); return res.json(); })
                .then(data => {
                    const akun = document.getElementById('akun_rekening');
                    akun.innerHTML = `<option value="">-- Pilih Akun --</option>`;
                    akun.disabled = false;
                    data.forEach(a => {
                        const opt = document.createElement('option');
                        opt.value = a.kode_akun;
                        opt.textContent = `${a.kode_akun} - ${a.nama_akun}`;
                        akun.appendChild(opt);
                    });
                })
                .catch(() => alert('Gagal memuat data akun'));
        });

        /* Akun → Rincian */
        document.getElementById('akun_rekening').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            if (!selected) { document.getElementById('nama_akun').value = ''; return; }

            const nama = selected.textContent.split(' - ').slice(1).join(' - ');
            document.getElementById('nama_akun').value = nama.trim();

            const akun     = this.value;
            const versi    = document.getElementById('versi').value;
            const program  = document.getElementById('program').value;
            const kegiatan = document.getElementById('kegiatan').value;
            const sub      = document.getElementById('sub_kegiatan').value;

            if (!akun || !versi || !program || !kegiatan || !sub) {
                document.getElementById('tabelRincian').innerHTML = '';
                return;
            }

            fetch(`/a2/filter-rincian`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ versi, program, kegiatan, sub_kegiatan: sub, akun })
            })
                .then(res => { if (!res.ok) throw new Error('Server error'); return res.json(); })
                .then(data => {
                    const html = data.map((row, i) => `
                        {{-- ✦ DIUBAH: tambah data-sisa-nom dan data-id-rinci di <tr> --}}
                        <tr class="${i % 2 === 0 ? '' : 'bg-slate-50'}"
                            data-sisa-nom="${row.sisa_nom}"
                            data-id-rinci="${row.id_rinci_sub_bl}">
                            <td class="border border-slate-200 px-2 py-1 text-center text-slate-500">${row.id_rinci_sub_bl}</td>
                            <td class="border border-slate-200 px-2 py-1">${row.nama_komponen}</td>
                            <td class="border border-slate-200 px-2 py-1 text-center">${row.satuan}</td>
                            <td class="border border-blue-100 px-2 py-1 text-center bg-blue-50">${row.volume}</td>
                            <td class="border border-blue-100 px-2 py-1 text-right bg-blue-50">${Number(row.harga_satuan).toLocaleString('id-ID')}</td>
                            <td class="border border-blue-100 px-2 py-1 text-right bg-blue-50 font-semibold">${(row.volume * row.harga_satuan).toLocaleString('id-ID')}</td>
                            <td class="border border-green-100 px-1 py-1 bg-green-50">
                                <input type="number" name="riil[${i}][vol]" step="any"
                                    class="w-20 border border-slate-300 rounded px-1 py-0.5 text-xs text-center focus:outline-none focus:ring-1 focus:ring-green-400"
                                    oninput="hitungRiilBaris(${i})">
                            </td>
                            <td class="border border-green-100 px-1 py-1 bg-green-50">
                                <input type="text" name="riil[${i}][harga]" step="any"
                                    class="w-20 border border-slate-300 rounded px-1 py-0.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-green-400"
                                    oninput="hitungRiilBaris(${i})"
                                    onfocus="unformatNumber(this)"
                                    onblur="formatNumber(this)"
                                    id="harga_riil_${i}">
                            </td>
                            <td class="border border-green-100 px-2 py-1 text-center bg-green-50">
                                <input type="checkbox" name="riil[${i}][ppn]" onclick="cekStatus(${i})"
                                    id="ppn_riil_${i}" class="w-3 h-3 accent-green-600">
                            </td>
                            <td class="border border-green-100 px-2 py-1 text-center bg-green-50">
                                <input type="checkbox" name="riil[${i}][iwp]" onclick="cekIWP(${i})"
                                    id="iwp_riil_${i}" class="w-3 h-3 accent-green-600">
                            </td>
                            <td class="border border-green-100 px-1 py-1 bg-green-50">
                                <input type="text" readonly id="nominal_riil_${i}"
                                    class="w-24 text-right bg-green-100 border border-green-200 rounded px-1 py-0.5 text-xs font-semibold text-green-700 cursor-not-allowed">
                            </td>
                            <td class="border border-indigo-100 px-2 py-1 text-center text-slate-600 bg-indigo-50">${row.reg_vol}</td>
                            <td class="border border-indigo-100 px-2 py-1 text-right text-slate-600 bg-indigo-50">${Number(row.reg_nom).toLocaleString('id-ID')}</td>
                            <td class="border border-indigo-100 px-2 py-1 text-center font-bold text-red-600 bg-indigo-50">${row.sisa_vol}</td>
                            <td class="border border-indigo-100 px-2 py-1 text-right font-bold text-red-600 bg-indigo-50">${Number(row.sisa_nom).toLocaleString('id-ID')}</td>
                            <input type="hidden" name="riil[${i}][id_rinci_sub_bl]" value="${row.id_rinci_sub_bl}">
                            <input type="hidden" name="riil[${i}][nama_komponen]"   value="${row.nama_komponen}">
                            <input type="hidden" name="riil[${i}][kode_dana]"       value="${row.kode_dana}">
                            <input type="hidden" name="riil[${i}][nama_dana]"       value="${row.nama_dana}">
                            <input type="hidden" name="riil[${i}][opd_id]"          value="${row.opd_id}">
                            <input type="hidden" name="riil[${i}][unit_id]"         value="${row.unit_id}">
                            <input type="hidden" name="riil[${i}][kode_skpd]"       value="${row.kode_skpd}">
                            <input type="hidden" name="riil[${i}][nama_skpd]"       value="${row.nama_skpd}">
                            <input type="hidden" name="riil[${i}][pptk_id]"         value="${row.pptk_id}">
                            <input type="hidden" name="riil[${i}][pokja_id]"        value="${row.pokja_id}">
                        </tr>
                    `).join('');
                    document.getElementById('tabelRincian').innerHTML = html;
                })
                .catch(() => alert('Gagal memuat data rincian'));
        });
    });

    /* ─────────────────────────────────────────
     * PENERIMA
     * ───────────────────────────────────────── */
    function isiDataPenerima() {
        const select = document.getElementById('penerima');
        const option = select.options[select.selectedIndex];
        document.getElementById('nama_penerima').value  = option.getAttribute('data-nama')   || '';
        document.getElementById('npwp').value           = option.getAttribute('data-npwp')   || '';
        document.getElementById('bank_penerima').value  = option.getAttribute('data-bank')   || '';
        document.getElementById('norek_penerima').value = option.getAttribute('data-norek')  || '';
        document.getElementById('alamat_penerima').value= option.getAttribute('data-alamat') || '';
    }

    /* ─────────────────────────────────────────
     * FORMAT & PARSE RUPIAH
     * ───────────────────────────────────────── */
    function parseRupiah(val) {
        if (!val) return 0;
        return parseFloat(
            val.toString()
                .replace(/\./g, '')
                .replace(',', '.')
                .replace(/[^0-9.]/g, '')
        ) || 0;
    }

    function formatRupiah(num) {
        return Number(num || 0).toLocaleString('id-ID');
    }

    function unformatNumber(el) {
        el.value = el.value.replace(/\./g, '').replace(',', '.');
    }

    function formatNumber(el) {
        if (!el.value) return;
        const angka = parseRupiah(el.value);
        el.value = angka.toLocaleString('id-ID', {
            minimumFractionDigits: angka % 1 === 0 ? 0 : 2,
            maximumFractionDigits: 2
        });
    }

    /* ─────────────────────────────────────────
     * HITUNG BRUTO / NETTO
     * ───────────────────────────────────────── */
    function hitungBruto() {
        let total = 0;
        document.querySelectorAll('[id^="nominal_riil_"]').forEach(el => { total += parseRupiah(el.value); });
        document.getElementById('bruto').value = formatRupiah(total);
        document.getElementById('bruto_terbilang').value = total > 0 ? terbilang(total) + ' Rupiah' : '';
        hitungSemuaPajak();
        hitungTotalPajak();
    }

    function hitungNetto() {
        const bruto    = parseRupiah(document.getElementById('bruto').value);
        const potongan = parseRupiah(document.getElementById('totalPotongan').value);
        const netto    = bruto - potongan;
        document.getElementById('netto').value    = formatRupiah(netto);
        document.getElementById('terbilang').value = netto > 0 ? terbilang(netto) + ' Rupiah' : '';
    }

    function hitungRiilBaris(i) {
        const vol  = Number(document.querySelector(`input[name="riil[${i}][vol]"]`)?.value || 0);
        let harga  = parseRupiah(document.querySelector(`input[name="riil[${i}][harga]"]`)?.value || 0);
        const ppn  = {{ $ppn->tarif }};
        const cb   = document.getElementById(`ppn_riil_${i}`);
        if (cb.checked) harga = harga * (100 + ppn) / 100;
        const total = vol * harga;
        document.getElementById(`nominal_riil_${i}`).value = total > 0 ? formatRupiah(total) : '';
        hitungBruto();
        hitungTotalPajak();
        cekSaldoBaris(i); /* ✦ TAMBAHAN: validasi saldo real-time */
    }

    function cekStatus(i) {
        const ppn   = {{ $ppn->tarif }};
        const cb    = document.getElementById(`ppn_riil_${i}`);
        const vol   = Number(document.querySelector(`input[name="riil[${i}][vol]"]`)?.value || 0);
        let harga   = parseRupiah(document.querySelector(`input[name="riil[${i}][harga]"]`)?.value || 0);
        if (cb.checked) harga = harga * (100 + ppn) / 100;
        const total = vol * harga;
        document.getElementById(`nominal_riil_${i}`).value = total > 0 ? formatRupiah(total) : '';
        hitungBruto();
        cekSaldoBaris(i); /* ✦ TAMBAHAN: validasi saldo saat centang PPN */
    }

    function cekIWP(i) {
        hitungTotalPajak();
    }

    /* ─────────────────────────────────────────
     * ✦ CEK SALDO ANGGARAN — REAL TIME
     * Warnai baris merah jika nominal riil
     * melebihi sisa saldo komponen.
     * ───────────────────────────────────────── */
    function cekSaldoBaris(i) {
        const tr = document.querySelector(`input[name="riil[${i}][vol]"]`)?.closest('tr');
        if (!tr) return true;

        const sisaNom  = parseFloat(tr.dataset.sisaNom) || 0;
        const vol      = Number(document.querySelector(`input[name="riil[${i}][vol]"]`)?.value || 0);
        const harga    = parseRupiah(document.querySelector(`input[name="riil[${i}][harga]"]`)?.value || 0);
        const nominal  = vol * harga;
        const nomEl    = document.getElementById(`nominal_riil_${i}`);

        if (sisaNom > 0 && nominal > sisaNom) {
            /* Tandai baris & kolom nominal merah */
            tr.classList.add('bg-red-50');
            tr.classList.remove('bg-slate-50');
            if (nomEl) {
                nomEl.classList.add('bg-red-200', 'text-red-700', 'border-red-400');
                nomEl.classList.remove('bg-green-100', 'text-green-700', 'border-green-200');
            }
            return false;
        } else {
            /* Kembalikan ke normal */
            tr.classList.remove('bg-red-50');
            if (nomEl) {
                nomEl.classList.remove('bg-red-200', 'text-red-700', 'border-red-400');
                nomEl.classList.add('bg-green-100', 'text-green-700', 'border-green-200');
            }
            return true;
        }
    }

    /* ─────────────────────────────────────────
     * ✦ SUBMIT DENGAN CEK SALDO
     * Dipanggil dari tombol "Ya, Simpan" di modal.
     * Jika ada baris yang melebihi sisa saldo,
     * batalkan submit dan tampilkan pesan error.
     * ───────────────────────────────────────── */
    function submitDenganCekSaldo() {
        const rows = document.querySelectorAll('#tabelRincian tr[data-sisa-nom]');
        let adaPelanggaran = false;
        const pesanError = [];

        rows.forEach((tr, i) => {
            const sisaNom = parseFloat(tr.dataset.sisaNom) || 0;
            const volInput = tr.querySelector(`input[name="riil[${i}][vol]"]`);
            const hargaInput = tr.querySelector(`input[name="riil[${i}][harga]"]`);
            if (!volInput || !hargaInput) return;

            const vol = Number(volInput.value || 0);
            const harga = parseRupiah(hargaInput.value || 0);
            const nominal = vol * harga;

            if (sisaNom > 0 && nominal > sisaNom) {
                adaPelanggaran = true;
                pesanError.push(nominal);
            }
        });

        if (adaPelanggaran) {
            const alertEl = document.getElementById('saldo-error-alert');
            alertEl.innerHTML = `<b>⚠ Saldo tidak mencukupi</b>`;
            alertEl.style.display = 'block';

            alertEl.scrollIntoView({ behavior: 'smooth' });

            return false; // ❌ penting: jangan submit
        }

        document.getElementById('saldo-error-alert').style.display = 'none';
        document.getElementById('form-a2').submit();
        return true;
    }

    /* ─────────────────────────────────────────
     * PAJAK
     * ───────────────────────────────────────── */
    function hitungPajakManual() {
        const iv   = (Number(vol_iv.value)   || 0) * (Number(besaran_iv.value)   || 0) * 0.15;
        const iii  = (Number(vol_iii.value)  || 0) * (Number(besaran_iii.value)  || 0) * 0.05;
        const lain = (Number(vol_lain.value) || 0) * (Number(besaran_lain.value) || 0) * 0.06;
        pajak_iv.innerText   = iv   ? formatRupiah(iv)   : 0;
        pajak_iii.innerText  = iii  ? formatRupiah(iii)  : 0;
        pajak_lain.innerText = lain ? formatRupiah(lain) : 0;

        hitungSemuaPajak();
        hitungTotalPajak();
    }

    function hitungPajakBaris(select) {
        const row          = select.closest('tr');
        const kode         = select.value;
        const selectedOpt  = select.options[select.selectedIndex];
        const jenisPajak   = selectedOpt?.dataset?.jenis || '';
        row.querySelector('input[name="pajak[jenis][]"]').value = jenisPajak;

        const bruto = parseRupiah(document.getElementById('bruto')?.value || 0);
        const dpp   = (100 / 111) * bruto;
        let nominal = 0;

        switch (kode) {
            case '411121-402':
                const iv   = (Number(vol_iv.value)   || 0) * (Number(besaran_iv.value)   || 0) * 0.15;
                const iii  = (Number(vol_iii.value)  || 0) * (Number(besaran_iii.value)  || 0) * 0.05;
                const lain = (Number(vol_lain.value) || 0) * (Number(besaran_lain.value) || 0) * 0.06;
                nominal = iv + iii + lain;
                break;
            case '411121-21-100-20': nominal = 0.05 * dpp;               break;
            case '411122-920':       nominal = 0.015 * dpp;              break;
            case '411124-100':
            case '411124-104':       nominal = 0.02 * dpp;               break;
            case '411211-920':       nominal = 0.12 * (11 / 12 * dpp);   break;
            case '999999-100':
            case '999999-200':       nominal = 0.10 * bruto;             break;
            default:                 nominal = 0;
        }

        nominal = Math.round(nominal);
        row.querySelector('input[name="pajak[nominal][]"]').value = formatRupiah(nominal);

        const kodeCell = row.querySelector('.kode-pajak');
        if (kodeCell) kodeCell.innerText = kode || '-';

        hitungTotalPajak();
    }

    function hitungTotalIWP() {
        let totalIWP = 0;
        const umk  = {{ $umk }};
        document.querySelectorAll('[id^="iwp_riil_"]').forEach((cb, i) => {
            if (cb.checked) {
                const vol   = Number(document.querySelector(`input[name="riil[${i}][vol]"]`)?.value || 0);
                const harga = parseRupiah(document.querySelector(`input[name="riil[${i}][harga]"]`)?.value || 0);
                totalIWP += Math.round(Math.max(vol * harga, umk) * 0.01);
            }
        });
        document.getElementById('iwpTotal').value         = formatRupiah(totalIWP);
        document.getElementById('iwp_total_hidden').value = totalIWP;
        return totalIWP;
    }

    function hitungTotalPajak() {
        let pajakManual = 0;
        document.querySelectorAll('input[name="pajak[nominal][]"]').forEach(el => {
            pajakManual += parseRupiah(el.value || 0);
        });
        const iwp           = hitungTotalIWP();
        const totalPotongan = pajakManual + iwp;
        document.getElementById('pajakPotong').value   = formatRupiah(pajakManual);
        document.getElementById('totalPotongan').value = formatRupiah(totalPotongan);
        hitungNetto();
    }

    function hitungSemuaPajak() {
        document.querySelectorAll('select[name="pajak[kode][]"]').forEach(select => {
            if (select.value) hitungPajakBaris(select);
        });
    }

    function tambahPajak() {
        const body = document.getElementById('body_pajak');
        const rows = body.querySelectorAll('.pajak-row');
        if (rows.length >= 2) { alert('Maksimal 2 pajak'); return; }

        const clone = rows[0].cloneNode(true);
        clone.querySelector('select').value = '';
        clone.querySelector('input[name="pajak[nominal][]"]').value = 0;

        const kodeCell = clone.querySelector('.kode-pajak');
        if (kodeCell) kodeCell.innerText = '-';

        clone.querySelector('button').outerHTML = `
            <button type="button" onclick="hapusPajak(this)"
                class="bg-red-600 hover:bg-red-700 text-white w-6 h-6 rounded text-xs font-bold transition-colors">
                &minus;
            </button>`;

        body.appendChild(clone);
    }

    function hapusPajak(btn) {
        btn.closest('.pajak-row').remove();
        hitungTotalPajak();
    }

    /* ─────────────────────────────────────────
     * TERBILANG
     * ───────────────────────────────────────── */
    function terbilangInt(n) {
        n = Math.floor(n);
        const angka = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
                        'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        if (n < 12)         return angka[n];
        if (n < 20)         return terbilangInt(n - 10) + ' Belas';
        if (n < 100)        return terbilangInt(Math.floor(n / 10)) + ' Puluh '  + terbilangInt(n % 10);
        if (n < 200)        return 'Seratus ' + terbilangInt(n - 100);
        if (n < 1000)       return terbilangInt(Math.floor(n / 100))  + ' Ratus ' + terbilangInt(n % 100);
        if (n < 2000)       return 'Seribu '  + terbilangInt(n - 1000);
        if (n < 1_000_000)  return terbilangInt(Math.floor(n / 1000)) + ' Ribu '  + terbilangInt(n % 1000);
        if (n < 1_000_000_000) return terbilangInt(Math.floor(n / 1_000_000)) + ' Juta ' + terbilangInt(n % 1_000_000);
        return '';
    }

    function terbilang(n) {
        n = Number(n);
        if (isNaN(n)) return '';
        const rupiah = Math.floor(n);
        const sen    = Math.round((n - rupiah) * 100);
        let hasil    = terbilangInt(rupiah);
        if (sen > 0) hasil += ' ' + terbilangInt(sen) + ' Sen';
        return hasil.trim();
    }

    function handleBeforeConfirm() {
        const rows = document.querySelectorAll('#tabelRincian tr[data-sisa-nom]');
        let adaPelanggaran = false;

        rows.forEach((tr, i) => {
            const sisaNom = parseFloat(tr.dataset.sisaNom) || 0;

            const volInput = tr.querySelector(`input[name="riil[${i}][vol]"]`);
            const hargaInput = tr.querySelector(`input[name="riil[${i}][harga]"]`);

            if (!volInput || !hargaInput) return;

            const vol = Number(volInput.value || 0);
            const harga = parseRupiah(hargaInput.value || 0);
            const nominal = vol * harga;

            if (sisaNom > 0 && nominal > sisaNom) {
                adaPelanggaran = true;
            }
        });

        if (adaPelanggaran) {
            const alertEl = document.getElementById('saldo-error-alert');
            alertEl.innerHTML = `<b>⚠ Saldo tidak mencukupi</b>`;
            alertEl.style.display = 'block';
            alertEl.scrollIntoView({ behavior: 'smooth' });

            return; // ❌ STOP, jangan buka modal
        }

        // ✔️ baru buka modal kalau aman
        open = true;
    }

    function a2Form() {
    return {
        open: false,

        handleBeforeConfirm() {
            const rows = document.querySelectorAll('#tabelRincian tr[data-sisa-nom]');
            let adaPelanggaran = false;

            rows.forEach((tr, i) => {
                const sisaNom = parseFloat(tr.dataset.sisaNom) || 0;

                const volInput = tr.querySelector(`input[name="riil[${i}][vol]"]`);
                const hargaInput = tr.querySelector(`input[name="riil[${i}][harga]"]`);

                if (!volInput || !hargaInput) return;

                const vol = Number(volInput.value || 0);
                const harga = parseRupiah(hargaInput.value || 0);
                const nominal = vol * harga;

                if (sisaNom > 0 && nominal > sisaNom) {
                    adaPelanggaran = true;
                }
            });

            if (adaPelanggaran) {
                const alertEl = document.getElementById('saldo-error-alert');
                alertEl.innerHTML = `<b>⚠ Saldo tidak mencukupi</b>`;
                alertEl.style.display = 'block';
                alertEl.scrollIntoView({ behavior: 'smooth' });
                return;
            }

            this.open = true; // ✅ INI KUNCI FIX
        },

        submitDenganCekSaldo() {
            const rows = document.querySelectorAll('#tabelRincian tr[data-sisa-nom]');
            let adaPelanggaran = false;

            rows.forEach((tr, i) => {
                const sisaNom = parseFloat(tr.dataset.sisaNom) || 0;

                const volInput = tr.querySelector(`input[name="riil[${i}][vol]"]`);
                const hargaInput = tr.querySelector(`input[name="riil[${i}][harga]"]`);

                if (!volInput || !hargaInput) return;

                const vol = Number(volInput.value || 0);
                const harga = parseRupiah(hargaInput.value || 0);
                const nominal = vol * harga;

                if (sisaNom > 0 && nominal > sisaNom) {
                    adaPelanggaran = true;
                }
            });

            if (adaPelanggaran) {
                const alertEl = document.getElementById('saldo-error-alert');
                alertEl.innerHTML = `<b>⚠ Saldo tidak mencukupi</b>`;
                alertEl.style.display = 'block';
                alertEl.scrollIntoView({ behavior: 'smooth' });
                return false;
            }

            document.getElementById('form-a2').submit();
            return true;
        }
    }
}
</script>
@endpush
