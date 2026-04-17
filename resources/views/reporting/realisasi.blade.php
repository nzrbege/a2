    @extends('layouts.app')

    @section('content')
    <div class="max-w-screen-xl mx-auto p-5">

        {{-- HEADER --}}
        <div class="bg-green-900 text-white text-center rounded-lg px-6 py-4 mb-4">
            <h1 class="text-sm font-semibold tracking-wide uppercase">Dashboard Cek Kendali Rincian Belanja</h1>
            <p class="text-xs mt-1 opacity-80">Berdasarkan Akun Rekening dan Sub Kegiatan &mdash; {{$kode_opd}} Kabupaten Klaten
                Tahun Anggaran {{ date('Y') }}</p>
        </div>

        {{-- INFO + FILTER --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-4">

            {{-- Identitas / Filter --}}
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3 pb-2 border-b border-gray-100">
                    Identitas Kegiatan
                </p>
                {{-- Versi terbaru diambil otomatis dari server, tidak ditampilkan ke user --}}
                <input type="hidden" id="versi" value="{{ $versiTerbaru ?? '' }}">

                <div class="space-y-3">

                    {{-- Program --}}
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-400 w-24 shrink-0">Program</label>
                        <select id="program"
                            class="w-full text-xs border border-gray-300 rounded-md px-2 py-1.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none"
                            disabled>
                            <option value="">-- Pilih Program --</option>
                        </select>
                    </div>

                    {{-- Kegiatan --}}
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-400 w-24 shrink-0">Kegiatan</label>
                        <select id="kegiatan"
                            class="w-full text-xs border border-gray-300 rounded-md px-2 py-1.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none"
                            disabled>
                            <option value="">-- Pilih Kegiatan --</option>
                        </select>
                    </div>

                    {{-- Sub Kegiatan --}}
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-400 w-24 shrink-0">Sub Kegiatan</label>
                        <select id="sub_kegiatan"
                            class="w-full text-xs border border-gray-300 rounded-md px-2 py-1.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none"
                            disabled>
                            <option value="">-- Pilih Sub Kegiatan --</option>
                        </select>
                    </div>

                    {{-- Rekening --}}
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-gray-400 w-24 shrink-0">Rekening</label>
                        <select id="akun_rekening"
                            class="w-full text-xs border border-gray-300 rounded-md px-2 py-1.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none"
                            disabled>
                            <option value="">-- Pilih Rekening --</option>
                        </select>
                    </div>

                    {{-- Hidden helpers --}}
                    <input type="hidden" id="nama_program">
                    <input type="hidden" id="nama_giat">
                    <input type="hidden" id="nama_sub_giat">
                    <input type="hidden" id="nama_akun">
                </div>
            </div>

            {{-- Summary Anggaran — diupdate dinamis via JS --}}
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3 pb-2 border-b border-gray-100">
                    Ringkasan Realisasi
                </p>

                {{-- Metric row --}}
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <p class="text-xs text-green-600 uppercase font-semibold mb-1">Sudah Disahkan</p>
                        <p id="sum_disahkan" class="text-sm font-bold text-green-700">—</p>
                        <div class="w-full bg-green-100 rounded-full h-1.5 mt-1.5">
                            <div id="bar_disahkan" class="bg-green-500 h-1.5 rounded-full transition-all" style="width:0%"></div>
                        </div>
                        <p id="pct_disahkan" class="text-xs text-green-500 mt-1">0% dari pagu</p>
                    </div>
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                        <p class="text-xs text-orange-600 uppercase font-semibold mb-1">Dalam Pengesahan</p>
                        <p id="sum_pending" class="text-sm font-bold text-orange-600">—</p>
                        <div class="w-full bg-orange-100 rounded-full h-1.5 mt-1.5">
                            <div id="bar_pending" class="bg-orange-400 h-1.5 rounded-full transition-all" style="width:0%"></div>
                        </div>
                        <p id="pct_pending" class="text-xs text-orange-500 mt-1">0% dari pagu</p>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs text-blue-600 uppercase font-semibold mb-1">Total Anggaran</p>
                        <p id="sum_total_anggaran" class="text-sm font-bold text-blue-700">—</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                        <p class="text-xs text-slate-500 uppercase font-semibold mb-1">Sisa Anggaran</p>
                        <p id="sum_sisa" class="text-sm font-bold text-slate-700">—</p>
                    </div>
                </div>

                {{-- Progress bar gabungan --}}
                <div class="space-y-1.5">
                    <div class="flex justify-between text-xs text-gray-400">
                        <span>Realisasi Keseluruhan</span>
                        <span id="pct_total_label">— %</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                        <div class="h-3 rounded-full flex">
                            <div id="bar_total_disahkan" class="bg-green-500 h-3 transition-all" style="width:0%"></div>
                            <div id="bar_total_pending"  class="bg-orange-400 h-3 transition-all" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="flex gap-4 text-xs text-gray-400">
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-sm bg-green-500 inline-block"></span>Disahkan</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-sm bg-orange-400 inline-block"></span>Pending</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-sm bg-gray-200 inline-block"></span>Sisa</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RINCIAN KOMPONEN BELANJA --}}
        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between pb-2 border-b border-gray-100 mb-3">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Rincian Komponen Belanja</p>
                <span id="status_label" class="text-xs text-gray-400 italic">Pilih semua filter untuk memuat data...</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs" style="min-width:900px">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">ID Komponen</th>
                            <th class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Satuan</th>
                            <th class="text-left text-gray-500 font-semibold px-2 py-2 border border-gray-200" style="min-width:200px">Urai Komponen</th>
                            {{-- <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Vol Sebelum</th> --}}
                            {{-- <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Vol Setelah</th> --}}
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Volume</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Harga Satuan</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Total (Rp)</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Disahkan Vol</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Disahkan Total</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Pending Vol</th>
                            <th class="text-right text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Pending Total</th>
                            <th class="text-center text-gray-500 font-semibold px-2 py-2 border border-gray-200 whitespace-nowrap">Sisa Vol / Total</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <tr>
                            <td colspan="12" class="text-center py-8 text-gray-400 text-xs italic">
                                Pilih Versi DPA, Program, Kegiatan, Sub Kegiatan, dan Rekening untuk memuat data.
                            </td>
                        </tr>
                    </tbody>
                    <tfoot id="tfoot"></tfoot>
                </table>
            </div>
        </div>

    </div>
    @endsection

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ─────────────────────────────────────
        * HELPERS
        * ───────────────────────────────────── */
        const fmt = n => (n === 0 || n === null || n === undefined)
            ? '&mdash;'
            : Number(n).toLocaleString('id-ID');

        const fmtRp = n => 'Rp ' + Number(n || 0).toLocaleString('id-ID');

        function setStatus(msg, loading = false) {
            const el = document.getElementById('status_label');
            el.textContent = msg;
            el.className = loading
                ? 'text-xs text-blue-500 italic animate-pulse'
                : 'text-xs text-gray-400 italic';
        }

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

        /* ─────────────────────────────────────
        * AUTO-LOAD PROGRAM PAKAI VERSI TERBARU
        * ───────────────────────────────────── */
        const versiTerbaru = document.getElementById('versi').value;

        if (versiTerbaru) {
            setLoadingSelect('program', 'Memuat Program...');
            fetch(`/a2/program-by-dpa/${versiTerbaru}`)
                .then(res => { if (!res.ok) throw new Error(); return res.json(); })
                .then(data => {
                    const el = document.getElementById('program');
                    el.innerHTML = `<option value="">-- Pilih Program --</option>`;
                    el.disabled = false;
                    data.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.kode_program;
                        opt.textContent = `${p.kode_program} - ${p.nama_program}`;
                        el.appendChild(opt);
                    });
                })
                .catch(() => {
                    resetSelect('program', '-- Gagal memuat, reload halaman --');
                });
        }

        /* ─────────────────────────────────────
        * CASCADING: PROGRAM → KEGIATAN
        * ───────────────────────────────────── */
        document.getElementById('program').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('nama_program').value = selected ? selected.textContent.trim() : '';

            const programId = this.value;
            resetSelect('kegiatan', '-- Pilih Kegiatan --');
            resetSelect('sub_kegiatan', '-- Pilih Sub Kegiatan --');
            resetSelect('akun_rekening', '-- Pilih Rekening --');
            resetTabel();

            if (!programId) return;

            setLoadingSelect('kegiatan', 'Memuat Kegiatan...');

            fetch(`/a2/kegiatan-by-program/${programId}`)
                .then(res => { if (!res.ok) throw new Error(); return res.json(); })
                .then(data => {
                    const el = document.getElementById('kegiatan');
                    el.innerHTML = `<option value="">-- Pilih Kegiatan --</option>`;
                    el.disabled = false;
                    data.forEach(k => {
                        const opt = document.createElement('option');
                        opt.value = k.kode_giat;
                        opt.textContent = k.nama_giat;
                        el.appendChild(opt);
                    });
                })
                .catch(() => alert('Gagal memuat data kegiatan'));
        });

        /* ─────────────────────────────────────
        * CASCADING: KEGIATAN → SUB KEGIATAN
        * ───────────────────────────────────── */
        document.getElementById('kegiatan').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('nama_giat').value = selected ? selected.textContent.trim() : '';

            const kegiatanId = this.value;
            resetSelect('sub_kegiatan', '-- Pilih Sub Kegiatan --');
            resetSelect('akun_rekening', '-- Pilih Rekening --');
            resetTabel();

            if (!kegiatanId) return;

            setLoadingSelect('sub_kegiatan', 'Memuat Sub Kegiatan...');

            fetch(`/a2/subkegiatan-by-kegiatan/${kegiatanId}`)
                .then(res => { if (!res.ok) throw new Error(); return res.json(); })
                .then(data => {
                    const el = document.getElementById('sub_kegiatan');
                    el.innerHTML = `<option value="">-- Pilih Sub Kegiatan --</option>`;
                    el.disabled = false;
                    data.forEach(s => {
                        const opt = document.createElement('option');
                        opt.value = s.kode_sub_giat;
                        opt.textContent = s.nama_sub_giat;
                        el.appendChild(opt);
                    });
                })
                .catch(() => alert('Gagal memuat data sub kegiatan'));
        });

        /* ─────────────────────────────────────
        * CASCADING: SUB KEGIATAN → AKUN
        * ───────────────────────────────────── */
        document.getElementById('sub_kegiatan').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('nama_sub_giat').value = selected ? selected.textContent.trim() : '';

            const sub = this.value;
            resetSelect('akun_rekening', '-- Pilih Rekening --');
            resetTabel();

            if (!sub) return;

            setLoadingSelect('akun_rekening', 'Memuat Akun...');

            fetch(`/a2/akun-by-subkegiatan/${sub}`)
                .then(res => { if (!res.ok) throw new Error(); return res.json(); })
                .then(data => {
                    const el = document.getElementById('akun_rekening');
                    el.innerHTML = `<option value="">-- Pilih Rekening --</option>`;
                    el.disabled = false;
                    data.forEach(a => {
                        const opt = document.createElement('option');
                        opt.value = a.kode_akun;
                        opt.textContent = `${a.kode_akun} - ${a.nama_akun}`;
                        el.appendChild(opt);
                    });
                })
                .catch(() => alert('Gagal memuat data akun'));
        });

        /* ─────────────────────────────────────
        * AKUN → FETCH RINCIAN + UPDATE SUMMARY
        * ───────────────────────────────────── */
        document.getElementById('akun_rekening').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            if (selected) {
                const nama = selected.textContent.split(' - ').slice(1).join(' - ');
                document.getElementById('nama_akun').value = nama.trim();
            }

            const akun     = this.value;
            const versi    = document.getElementById('versi').value;
            const program  = document.getElementById('program').value;
            const kegiatan = document.getElementById('kegiatan').value;
            const sub      = document.getElementById('sub_kegiatan').value;

            if (!akun || !versi || !program || !kegiatan || !sub) {
                resetTabel();
                return;
            }

            muatRincian(versi, program, kegiatan, sub, akun);
        });

        /* ─────────────────────────────────────
        * FETCH RINCIAN
        * ───────────────────────────────────── */
        function muatRincian(versi, program, kegiatan, sub, akun) {
            setStatus('Memuat data...', true);

            console.log(versi, program, kegiatan, sub, akun);

            const tbody = document.getElementById('tbody');
            tbody.innerHTML = `<tr><td colspan="12" class="text-center py-8 text-blue-400 text-xs italic animate-pulse">Memuat data komponen...</td></tr>`;
            document.getElementById('tfoot').innerHTML = '';

            fetch(`/reporting/filter-rincian`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ versi, program, kegiatan, sub_kegiatan: sub, akun })
            })
                .then(res => { if (!res.ok) throw new Error('Server error ' + res.status); return res.json(); })
                .then(data => {
                    console.log(data);
                    if (!data.length) {
                        tbody.innerHTML = `<tr><td colspan="12" class="text-center py-8 text-gray-400 text-xs italic">Tidak ada data komponen untuk filter ini.</td></tr>`;
                        setStatus('Tidak ada data.');
                        resetSummary();
                        return;
                    }

                    renderTabel(data);
                    updateSummary(data);
                    setStatus(`${data.length} komponen ditemukan.`);
                })
                .catch(err => {
                    tbody.innerHTML = `<tr><td colspan="12" class="text-center py-8 text-red-400 text-xs">Gagal memuat data: ${err.message}</td></tr>`;
                    setStatus('Gagal memuat data.');
                });
        }

        /* ─────────────────────────────────────
        * RENDER TABEL
        * ───────────────────────────────────── */
        function renderTabel(data) {
            console.log(data);
            const tbody = document.getElementById('tbody');
            let sumTot = 0, sumDt = 0, sumPt = 0, sumSisa = 0;

            tbody.innerHTML = data.map((r, i) => {
                const sisa_vol = (r.sisa_vol ??  0);
                const tot      = Number((r.volume * r.harga_satuan) ?? 0);
                const dt       = Number(r.nom_sah ?? 0);
                const pt       = Number(r.nom_pending ?? 0);
                const sisa_tot = r.sisa_nom ?? 0;

                sumTot  += tot;
                sumDt   += dt;
                sumPt   += pt;
                sumSisa += sisa_tot;

                const sisaClass = sisa_tot > 0
                    ? 'bg-green-100 text-green-800'
                    : sisa_tot < 0
                    ? 'bg-red-100 text-red-800'
                    : 'bg-gray-100 text-gray-500';

                const rowBg = i % 2 === 0 ? '' : 'bg-gray-50';

                return `<tr class="${rowBg}">
                    <td class="px-2 py-1.5 border border-gray-100 font-semibold text-blue-700">${r.id_rinci_sub_bl ?? r.id ?? '—'}</td>
                    <td class="px-2 py-1.5 border border-gray-100 whitespace-nowrap">${r.satuan ?? '—'}</td>
                    <td class="px-2 py-1.5 border border-gray-100">${r.nama_komponen ?? r.urai ?? '—'}</td>
                    <td class="px-2 py-1.5 border border-gray-100 text-right">${fmt(r.volume ?? 0)}</td>
                    <td class="px-2 py-1.5 border border-gray-100 text-right">${fmt(r.harga_satuan ?? 0)}</td>
                    <td class="px-2 py-1.5 border border-gray-100 text-right font-semibold">${fmt(tot)}</td>
                    <td class="px-2 py-1.5 border border-gray-100 text-right">${fmt(r.vol_sah ?? 0)}</td>
                    <td class="px-2 py-1.5 border border-gray-100 text-right">${fmt(r.nom_sah ?? 0)}</td>
                    <td class="px-2 py-1.5 border border-gray-100 text-right">${r.vol_pending ? fmt(r.vol_pending) : '&mdash;'}</td>
                    <td class="px-2 py-1.5 border border-gray-100 text-right">${r.nom_pending ? fmt(r.nom_pending) : '&mdash;'}</td>
                    <td class="px-2 py-1.5 border border-gray-100 text-center">
                        <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded ${sisaClass}">${r.sisa_vol} / ${fmt(r.sisa_nom)}</span>
                    </td>
                </tr>`;
            }).join('');

            document.getElementById('tfoot').innerHTML = `
                <tr class="bg-green-50 font-semibold text-green-900">
                    <td colspan="5" class="px-2 py-2 border border-gray-200 text-right font-bold">TOTAL</td>
                    <td class="px-2 py-2 border border-gray-200 text-right">${sumTot.toLocaleString('id-ID')}</td>
                    <td class="px-2 py-2 border border-gray-200 text-right">&mdash;</td>
                    <td class="px-2 py-2 border border-gray-200 text-right">${sumDt.toLocaleString('id-ID')}</td>
                    <td class="px-2 py-2 border border-gray-200 text-right">&mdash;</td>
                    <td class="px-2 py-2 border border-gray-200 text-right">${sumPt.toLocaleString('id-ID')}</td>
                    <td class="px-2 py-2 border border-gray-200 text-center">
                        <span class="inline-block bg-green-200 text-green-900 text-xs font-semibold px-2 py-0.5 rounded">${sumSisa.toLocaleString('id-ID')}</span>
                    </td>
                </tr>`;
        }

        /* ─────────────────────────────────────
        * UPDATE SUMMARY CARDS
        * ───────────────────────────────────── */
        function updateSummary(data) {
            let totalAnggaran = 0, totalDisahkan = 0, totalPending = 0;

            data.forEach(r => {
                totalAnggaran  += Number(r.total ?? r.tot ?? (r.volume * r.harga_satuan) ?? 0);
                totalDisahkan  += Number(r.nom_sah ?? 0);
                totalPending   += Number(r.nom_pending ?? 0);
            });

            const totalSisa = totalAnggaran - totalDisahkan - totalPending;
            const pctDisahkan = totalAnggaran > 0 ? Math.round((totalDisahkan / totalAnggaran) * 100) : 0;
            const pctPending  = totalAnggaran > 0 ? Math.round((totalPending  / totalAnggaran) * 100) : 0;

            document.getElementById('sum_disahkan').textContent        = fmtRp(totalDisahkan);
            document.getElementById('sum_pending').textContent         = fmtRp(totalPending);
            document.getElementById('sum_total_anggaran').textContent  = fmtRp(totalAnggaran);
            document.getElementById('sum_sisa').textContent            = fmtRp(totalSisa);

            document.getElementById('pct_disahkan').textContent        = `${pctDisahkan}% dari pagu`;
            document.getElementById('pct_pending').textContent         = `${pctPending}% dari pagu`;
            document.getElementById('pct_total_label').textContent     = `${pctDisahkan + pctPending}%`;

            document.getElementById('bar_disahkan').style.width        = `${pctDisahkan}%`;
            document.getElementById('bar_pending').style.width         = `${pctPending}%`;
            document.getElementById('bar_total_disahkan').style.width  = `${pctDisahkan}%`;
            document.getElementById('bar_total_pending').style.width   = `${pctPending}%`;
        }

        /* ─────────────────────────────────────
        * RESET
        * ───────────────────────────────────── */
        function resetTabel() {
            document.getElementById('tbody').innerHTML = `
                <tr><td colspan="12" class="text-center py-8 text-gray-400 text-xs italic">
                    Pilih semua filter untuk memuat data.
                </td></tr>`;
            document.getElementById('tfoot').innerHTML = '';
            setStatus('Pilih semua filter untuk memuat data...');
            resetSummary();
        }

        function resetSummary() {
            ['sum_disahkan','sum_pending','sum_total_anggaran','sum_sisa'].forEach(id => {
                document.getElementById(id).textContent = '—';
            });
            ['bar_disahkan','bar_pending','bar_total_disahkan','bar_total_pending'].forEach(id => {
                document.getElementById(id).style.width = '0%';
            });
            document.getElementById('pct_disahkan').textContent    = '0% dari pagu';
            document.getElementById('pct_pending').textContent     = '0% dari pagu';
            document.getElementById('pct_total_label').textContent = '— %';
        }

    });
    </script>
    @endpush
