@extends('layouts.app')

@section('content')
    <div class="max-w-screen-xl mx-auto p-5">

        <!-- HEADER -->
        <div class="bg-green-900 text-white text-center rounded-lg px-6 py-4 mb-4">
            <h1 class="text-sm font-semibold tracking-wide uppercase">Dashboard Cek Kendali Rincian Belanja</h1>
            <p class="text-xs mt-1 opacity-80">Berdasarkan Akun Rekening dan Sub Kegiatan &mdash; DISKOMINFO Kabupaten Klaten
                Tahun Anggaran {{ date('Y') }}</p>
        </div>

        <!-- INFO + ANGGARAN -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-4">

            <!-- Identitas -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3 pb-2 border-b border-gray-100">
                    Identitas Kegiatan</p>
                <div class="space-y-3">

                    <!-- Program -->
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-400 w-24 shrink-0">Program</label>
                        <select id="program"
                            class="w-full text-xs border-gray-300 rounded-md focus:ring-green-600 focus:border-green-600">
                            <option value="">-- Pilih Program --</option>
                            @foreach ($program as $v)
                                <option value="{{ $v->kode_program }}">
                                    {{ $v->kode_program.' - '.$v->nama_program }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                        <input type="hidden" name="nama_program" id="nama_program">
                        <input type="hidden" name="nama_giat" id="nama_giat">
                        <input type="hidden" name="nama_sub_giat" id="nama_sub_giat">
                        <input type="hidden" name="nama_akun" id="nama_akun">
                    <!-- Kegiatan -->
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-400 w-24 shrink-0">Kegiatan</label>
                        <select id="kegiatan"
                            class="w-full text-xs border-gray-300 rounded-md focus:ring-green-600 focus:border-green-600">
                            <option value="">-- Pilih Kegiatan --</option>
                        </select>
                    </div>

                    <!-- Sub Kegiatan -->
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-400 w-24 shrink-0">Sub Kegiatan</label>
                        <select id="sub_kegiatan"
                            class="w-full text-xs border-gray-300 rounded-md focus:ring-green-600 focus:border-green-600">
                            <option value="">-- Pilih Sub Kegiatan --</option>
                        </select>
                    </div>

                    <!-- Rekening -->
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-400 w-24 shrink-0">Rekening</label>
                        <select name="kode_akun" id="akun_rekening"
                            class="w-full text-xs border-gray-300 rounded-md focus:ring-green-600 focus:border-green-600">
                            <option value="">-- Pilih Rekening --</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- Anggaran & RAK -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3 pb-2 border-b border-gray-100">
                    Anggaran &amp; RAK Triwulan</p>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Sub Kegiatan (Murni)</p>
                        <p class="text-sm font-semibold text-gray-800">Rp 8.080.000.000</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Rekening (Murni)</p>
                        <p class="text-sm font-semibold text-gray-800">Rp 54.092.000</p>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-2">
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-2 text-center">
                        <p class="text-xs text-blue-500 mb-1">TW-I</p>
                        <p class="text-sm font-semibold text-blue-800">208.440</p>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-md p-2 text-center">
                        <p class="text-xs text-green-500 mb-1">TW-II</p>
                        <p class="text-sm font-semibold text-green-800">260.580</p>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-2 text-center">
                        <p class="text-xs text-yellow-500 mb-1">TW-III</p>
                        <p class="text-sm font-semibold text-yellow-800">50.400</p>
                    </div>
                    <div class="bg-pink-50 border border-pink-200 rounded-md p-2 text-center">
                        <p class="text-xs text-pink-500 mb-1">TW-IV</p>
                        <p class="text-sm font-semibold text-pink-800">21.500</p>
                    </div>
                </div>
                <p class="text-right text-xs text-gray-400 mt-2">Total RAK: <strong class="text-gray-700">540.920</strong>
                </p>
            </div>
        </div>

        <!-- METRIC CARDS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Sudah Disahkan</p>
                <p class="text-base font-semibold text-green-700">Rp 11.525.600</p>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                    <div class="bg-green-600 h-1.5 rounded-full" style="width:21%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">21% dari pagu rekening</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Dalam Pengesahan</p>
                <p class="text-base font-semibold text-orange-600">Rp 4.110.000</p>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                    <div class="bg-orange-500 h-1.5 rounded-full" style="width:8%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">8% dari pagu rekening</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Total Realisasi</p>
                <p class="text-base font-semibold text-blue-700">Rp 15.635.600</p>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width:29%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">29% dari pagu rekening</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Total Pagu Rekening</p>
                <p class="text-base font-semibold text-gray-800">Rp 54.092.000</p>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                    <div class="bg-gray-300 h-1.5 rounded-full w-full"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">Anggaran murni 2025</p>
            </div>
        </div>

        <!-- RAK BULANAN + REKAPITULASI -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-4">

            <!-- RAK Bulanan -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3 pb-2 border-b border-gray-100">
                    Rencana Anggaran Kas Bulanan</p>
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200">Bulan</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200">SPD (Rp)
                            </th>
                            <th class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200">Bulan</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200">SPD (Rp)
                            </th>
                            <th class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200">Bulan</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200">SPD (Rp)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="even:bg-gray-50">
                            <td class="px-2 py-1.5 border border-gray-100">1 — Januari</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right">25.200</td>
                            <td class="px-2 py-1.5 border border-gray-100">5 — Mei</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right">260.580</td>
                            <td class="px-2 py-1.5 border border-gray-100">9 — September</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right">25.200</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-2 py-1.5 border border-gray-100">2 — Februari</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right">158.040</td>
                            <td class="px-2 py-1.5 border border-gray-100">6 — Juni</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right text-gray-300">&mdash;</td>
                            <td class="px-2 py-1.5 border border-gray-100">10 — Oktober</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right text-gray-300">&mdash;</td>
                        </tr>
                        <tr>
                            <td class="px-2 py-1.5 border border-gray-100">3 — Maret</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right">25.200</td>
                            <td class="px-2 py-1.5 border border-gray-100">7 — Juli</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right">25.200</td>
                            <td class="px-2 py-1.5 border border-gray-100">11 — November</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right">21.500</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-2 py-1.5 border border-gray-100">4 — April</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right text-gray-300">&mdash;</td>
                            <td class="px-2 py-1.5 border border-gray-100">8 — Agustus</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right text-gray-300">&mdash;</td>
                            <td class="px-2 py-1.5 border border-gray-100">12 — Desember</td>
                            <td class="px-2 py-1.5 border border-gray-100 text-right text-gray-300">&mdash;</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Rekapitulasi SPJ -->
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3 pb-2 border-b border-gray-100">
                    Rekapitulasi SPJ</p>
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200">Status</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200">Volume</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200">Total (Rp)
                            </th>
                            <th class="text-center text-gray-500 font-semibold px-2 py-2 border border-gray-200">Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-2 py-2 border border-gray-100">
                                <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-1.5"></span>Sudah Disahkan
                            </td>
                            <td class="px-2 py-2 border border-gray-100 text-right text-gray-300">&mdash;</td>
                            <td class="px-2 py-2 border border-gray-100 text-right font-medium">11.525.600</td>
                            <td class="px-2 py-2 border border-gray-100 text-center">
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-0.5 rounded">Selesai</span>
                            </td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-2 py-2 border border-gray-100">
                                <span class="inline-block w-2 h-2 rounded-full bg-orange-400 mr-1.5"></span>Dalam
                                Pengesahan
                            </td>
                            <td class="px-2 py-2 border border-gray-100 text-right font-medium">4.110</td>
                            <td class="px-2 py-2 border border-gray-100 text-right font-medium">4.110.000</td>
                            <td class="px-2 py-2 border border-gray-100 text-center">
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-0.5 rounded">Proses</span>
                            </td>
                        </tr>
                        <tr class="bg-green-50 font-semibold">
                            <td class="px-2 py-2 border border-gray-200 text-green-900">Total</td>
                            <td class="px-2 py-2 border border-gray-200 text-right text-green-900">&mdash;</td>
                            <td class="px-2 py-2 border border-gray-200 text-right text-green-900">15.635.600</td>
                            <td class="px-2 py-2 border border-gray-200 text-center">
                                <span
                                    class="bg-green-200 text-green-900 text-xs font-semibold px-2 py-0.5 rounded">29%</span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Progress visual -->
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Realisasi Anggaran Rekening</span>
                        <span>29% dari Rp 54.092.000</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                        <div class="h-3 rounded-full flex">
                            <div class="bg-green-500 h-3" style="width:21%" title="Disahkan 21%"></div>
                            <div class="bg-orange-400 h-3" style="width:8%" title="Pending 8%"></div>
                        </div>
                    </div>
                    <div class="flex gap-4 text-xs text-gray-500">
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 rounded-sm bg-green-500 inline-block"></span>Disahkan 21%</span>
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 rounded-sm bg-orange-400 inline-block"></span>Pending 8%</span>
                        <span class="flex items-center gap-1"><span
                                class="w-2 h-2 rounded-sm bg-gray-200 inline-block"></span>Sisa 71%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RINCIAN KOMPONEN BELANJA -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3 pb-2 border-b border-gray-100">
                Rincian Komponen Belanja</p>
            <div class="overflow-x-auto">
                <table class="w-full text-xs" style="min-width:900px">
                    <thead>
                        <tr class="bg-gray-50">
                            <th
                                class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                ID Komponen</th>
                            <th
                                class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Satuan</th>
                            <th class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200"
                                style="min-width:200px">Urai Komponen</th>
                            <th
                                class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Vol Sebelum</th>
                            <th
                                class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Vol Setelah</th>
                            <th
                                class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Harga Satuan</th>
                            <th
                                class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Total (Rp)</th>
                            <th
                                class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Disahkan Vol</th>
                            <th
                                class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Disahkan Total</th>
                            <th
                                class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Pending Vol</th>
                            <th
                                class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Pending Total</th>
                            <th
                                class="text-center text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">
                                Sisa Vol / Total</th>
                        </tr>
                    </thead>
                    <tbody id="tbody"></tbody>
                    <tfoot id="tfoot"></tfoot>
                </table>
            </div>
        </div>

        <!-- FOOTER -->
        {{-- <p class="text-center text-xs text-gray-400 pb-4">
    Dicetak dari Sistem Informasi Manajemen Anggaran &mdash; DISKOMINFO Kabupaten Klaten &bull; Tahun Anggaran 2025
  </p> --}}

    </div>

    
@push('scripts')
    <script>
        const rows = [{
                id: "2605517",
                sat: "Orang/Hari",
                urai: "Uang Harian Perjalanan Dinas Luar Kota, D.K.I. Jakarta",
                vs: 15,
                vt: 9,
                hs: 530000,
                tot: 7950000,
                dv: 6,
                dt: 3180000,
                pv: 0,
                pt: 0
            },
            {
                id: "2605540",
                sat: "Orang/Hari",
                urai: "Satuan Biaya Penginapan DKI Jakarta, Pejabat Eselon IV/Gol III",
                vs: 4,
                vt: 2,
                hs: 730000,
                tot: 2920000,
                dv: 2,
                dt: 1460000,
                pv: 0,
                pt: 0
            },
            {
                id: "2605552",
                sat: "Orang/Hari",
                urai: "Satuan Biaya Penginapan DKI Jakarta, Pejabat Eselon III",
                vs: 2,
                vt: 2,
                hs: 992000,
                tot: 1984000,
                dv: 0,
                dt: 0,
                pv: 0,
                pt: 0
            },
            {
                id: "2605567",
                sat: "Rupiah",
                urai: "Tiket Kereta Api",
                vs: 7500,
                vt: 7500,
                hs: 1000,
                tot: 7500000,
                dv: 2600,
                dt: 2600000,
                pv: 4110,
                pt: 4110000
            },
            {
                id: "2605582",
                sat: "Orang/Kali",
                urai: "Satuan Biaya Taksi Perjalanan Dinas Dalam Negeri, D.K.I. Jakarta",
                vs: 5,
                vt: 5,
                hs: 256000,
                tot: 1280000,
                dv: 0.475,
                dt: 121600,
                pv: 0,
                pt: 0
            },
            {
                id: "2605598",
                sat: "Orang/Hari",
                urai: "Uang Harian Perjalanan Dinas Luar Kota, Jawa Tengah",
                vs: 35,
                vt: 15,
                hs: 370000,
                tot: 12950000,
                dv: 14,
                dt: 3800000,
                pv: 0,
                pt: 0
            },
            {
                id: "2605624",
                sat: "Rupiah",
                urai: "Biaya Tol",
                vs: 3704,
                vt: 3704,
                hs: 1000,
                tot: 3704000,
                dv: 364,
                dt: 364000,
                pv: 0,
                pt: 0
            },
            {
                id: "3885505",
                sat: "Orang/Hari",
                urai: "Satuan Biaya Penginapan Jawa Timur, Pejabat Eselon II/Anggota DPRD",
                vs: 2,
                vt: 0,
                hs: 1605000,
                tot: 3210000,
                dv: 0,
                dt: 0,
                pv: 0,
                pt: 0
            },
            {
                id: "3885511",
                sat: "Orang/Hari",
                urai: "Satuan Biaya Penginapan Jawa Timur, Pejabat Eselon IV/Gol III",
                vs: 6,
                vt: 0,
                hs: 664000,
                tot: 3984000,
                dv: 0,
                dt: 0,
                pv: 0,
                pt: 0
            },
            {
                id: "3885514",
                sat: "Orang/Hari",
                urai: "Uang Harian Perjalanan Dinas Luar Kota, Jawa Timur",
                vs: 21,
                vt: 0,
                hs: 410000,
                tot: 8610000,
                dv: 0,
                dt: 0,
                pv: 0,
                pt: 0
            },
        ];

        const fmt = n => n === 0 ? '&mdash;' : n.toLocaleString('id-ID');

        const tbody = document.getElementById('tbody');
        let sumTot = 0,
            sumDt = 0,
            sumPt = 0,
            sumSisa = 0;

        rows.forEach((r, i) => {
            const sisa_vol = r.vt - (r.dv + r.pv);
            const sisa_tot = r.tot - (r.dt + r.pt);
            sumTot += r.tot;
            sumDt += r.dt;
            sumPt += r.pt;
            sumSisa += sisa_tot;

            const sisaClass = sisa_tot > 0 ?
                'bg-green-100 text-green-800' :
                sisa_tot < 0 ?
                'bg-red-100 text-red-800' :
                'bg-gray-100 text-gray-500';

            const rowBg = i % 2 === 0 ? '' : 'bg-gray-50';

            const tr = document.createElement('tr');
            tr.className = rowBg;
            tr.innerHTML = `
    <td class="px-2 py-1.5 border border-gray-100 font-semibold text-blue-700">${r.id}</td>
    <td class="px-2 py-1.5 border border-gray-100 whitespace-nowrap">${r.sat}</td>
    <td class="px-2 py-1.5 border border-gray-100">${r.urai}</td>
    <td class="px-2 py-1.5 border border-gray-100 text-right">${fmt(r.vs)}</td>
    <td class="px-2 py-1.5 border border-gray-100 text-right">${fmt(r.vt)}</td>
    <td class="px-2 py-1.5 border border-gray-100 text-right">${fmt(r.hs)}</td>
    <td class="px-2 py-1.5 border border-gray-100 text-right font-semibold">${fmt(r.tot)}</td>
    <td class="px-2 py-1.5 border border-gray-100 text-right">${fmt(r.dv)}</td>
    <td class="px-2 py-1.5 border border-gray-100 text-right">${fmt(r.dt)}</td>
    <td class="px-2 py-1.5 border border-gray-100 text-right">${r.pv ? fmt(r.pv) : '&mdash;'}</td>
    <td class="px-2 py-1.5 border border-gray-100 text-right">${r.pt ? fmt(r.pt) : '&mdash;'}</td>
    <td class="px-2 py-1.5 border border-gray-100 text-center">
      <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded ${sisaClass}">${sisa_vol} / ${fmt(sisa_tot)}</span>
    </td>
  `;
            tbody.appendChild(tr);
        });

        document.getElementById('tfoot').innerHTML = `
  <tr class="bg-green-50 font-semibold text-green-900">
    <td colspan="6" class="px-2 py-2 border border-gray-200 text-right">TOTAL</td>
    <td class="px-2 py-2 border border-gray-200 text-right">${sumTot.toLocaleString('id-ID')}</td>
    <td class="px-2 py-2 border border-gray-200 text-right">&mdash;</td>
    <td class="px-2 py-2 border border-gray-200 text-right">${sumDt.toLocaleString('id-ID')}</td>
    <td class="px-2 py-2 border border-gray-200 text-right">&mdash;</td>
    <td class="px-2 py-2 border border-gray-200 text-right">${sumPt.toLocaleString('id-ID')}</td>
    <td class="px-2 py-2 border border-gray-200 text-center">
      <span class="inline-block bg-green-200 text-green-900 text-xs font-semibold px-2 py-0.5 rounded">${sumSisa.toLocaleString('id-ID')}</span>
    </td>
  </tr>
`;

    
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
                    console.log(data);
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
            console.log("kegiatan id: "+kegiatanId);
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
            console.log(selected);
            if (!selected) {
               document.getElementById('nama_akun').value = ''; return; }

            const nama = selected.textContent.split(' - ').slice(1).join(' - ');
            document.getElementById('nama_akun').value = nama.trim();

            const akun     = this.value;
            const versi    = document.getElementById('versi').value;
            const program  = document.getElementById('program').value;
            const kegiatan = document.getElementById('kegiatan').value;
            const sub      = document.getElementById('sub_kegiatan').value;

            console.log(versi,program,kegiatan,sub,akun);

            if (!akun || !versi || !program || !kegiatan || !sub) {
                document.getElementById('tabelRincian').innerHTML = '';
                return;
            }

            // fetch(`/a2/filter-rincian`, {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            //     body: JSON.stringify({ versi, program, kegiatan, sub_kegiatan: sub, akun })
            // })
            //     .then(res => { if (!res.ok) throw new Error('Server error'); return res.json(); })
            //     .then(data => {
            //         const html = data.map((row, i) => `
            //             <tr class="${i % 2 === 0 ? '' : 'bg-slate-50'}">
            //                 <td class="border border-slate-200 px-2 py-1 text-center text-slate-500">${row.id_rinci_sub_bl}</td>
            //                 <td class="border border-slate-200 px-2 py-1">${row.nama_komponen}</td>
            //                 <td class="border border-slate-200 px-2 py-1 text-center">${row.satuan}</td>
            //                 <td class="border border-blue-100 px-2 py-1 text-center bg-blue-50">${row.volume}</td>
            //                 <td class="border border-blue-100 px-2 py-1 text-right bg-blue-50">${Number(row.harga_satuan).toLocaleString('id-ID')}</td>
            //                 <td class="border border-blue-100 px-2 py-1 text-right bg-blue-50 font-semibold">${(row.volume * row.harga_satuan).toLocaleString('id-ID')}</td>
            //                 <td class="border border-green-100 px-1 py-1 bg-green-50">
            //                     <input type="number" name="riil[${i}][vol]" step="any"
            //                         class="w-20 border border-slate-300 rounded px-1 py-0.5 text-xs text-center focus:outline-none focus:ring-1 focus:ring-green-400"
            //                         oninput="hitungRiilBaris(${i})">
            //                 </td>
            //                 <td class="border border-green-100 px-1 py-1 bg-green-50">
            //                     <input type="text" name="riil[${i}][harga]" step="any"
            //                         class="w-20 border border-slate-300 rounded px-1 py-0.5 text-xs text-right focus:outline-none focus:ring-1 focus:ring-green-400"
            //                         oninput="hitungRiilBaris(${i})"
            //                         onfocus="unformatNumber(this)"
            //                         onblur="formatNumber(this)"
            //                         id="harga_riil_${i}">
            //                 </td>
            //                 <td class="border border-green-100 px-2 py-1 text-center bg-green-50">
            //                     <input type="checkbox" name="riil[${i}][ppn]" onclick="cekStatus(${i})"
            //                         id="ppn_riil_${i}" class="w-3 h-3 accent-green-600">
            //                 </td>
            //                 <td class="border border-green-100 px-2 py-1 text-center bg-green-50">
            //                     <input type="checkbox" name="riil[${i}][iwp]" onclick="cekIWP(${i})"
            //                         id="iwp_riil_${i}" class="w-3 h-3 accent-green-600">
            //                 </td>
            //                 <td class="border border-green-100 px-1 py-1 bg-green-50">
            //                     <input type="text" readonly id="nominal_riil_${i}"
            //                         class="w-24 text-right bg-green-100 border border-green-200 rounded px-1 py-0.5 text-xs font-semibold text-green-700 cursor-not-allowed">
            //                 </td>
            //                 <td class="border border-indigo-100 px-2 py-1 text-center text-slate-600 bg-indigo-50">${row.reg_sah_vol}</td>
            //                 <td class="border border-indigo-100 px-2 py-1 text-right text-slate-600 bg-indigo-50">${Number(row.reg_sah_nom).toLocaleString('id-ID')}</td>
            //                 <td class="border border-indigo-100 px-2 py-1 text-center font-bold text-red-600 bg-indigo-50">${row.sisa_vol}</td>
            //                 <td class="border border-indigo-100 px-2 py-1 text-right font-bold text-red-600 bg-indigo-50">${Number(row.sisa_nom).toLocaleString('id-ID')}</td>
            //                 <input type="hidden" name="riil[${i}][id_rinci_sub_bl]" value="${row.id_rinci_sub_bl}">
            //                 <input type="hidden" name="riil[${i}][nama_komponen]"   value="${row.nama_komponen}">
            //                 <input type="hidden" name="riil[${i}][kode_dana]"       value="${row.kode_dana}">
            //                 <input type="hidden" name="riil[${i}][nama_dana]"       value="${row.nama_dana}">
            //                 <input type="hidden" name="riil[${i}][kode_skpd]"       value="${row.kode_skpd}">
            //                 <input type="hidden" name="riil[${i}][nama_skpd]"       value="${row.nama_skpd}">
            //                 <input type="hidden" name="riil[${i}][pptk_id]"         value="${row.pptk_id}">
            //                 <input type="hidden" name="riil[${i}][pokja_id]"        value="${row.pokja_id}">
            //             </tr>
            //         `).join('');
            //         document.getElementById('tabelRincian').innerHTML = html;
            //     })
            //     .catch(() => alert('Gagal memuat data rincian'));
        });
    });
    </script>
@endpush
@endsection