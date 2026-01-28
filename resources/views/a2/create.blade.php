    @extends('layouts.app')

    <style>
        .table-compact th,
        .table-compact td {
            padding: 2px 4px !important;
            line-height: 1.2;
            font-size: 9px;
        }

        .table-compact input {
            height: 18px;
            font-size: 9px;
            padding: 0 4px;
        }

        .table-compact input[type="number"] {
            text-align: center;
        }

        .table-compact tr {
            height: 20px;
        }
    </style>


    @section('content')
        <div class="max-h-screen overflow-hidden p-2 bg-slate-100">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="form-a2" method="POST" action="{{ route('a2.store') }}" class="space-y-2">
                @csrf
                <div class="bg-blue-800 text-white px-4 py-1 rounded shadow-sm flex justify-between items-center">
                    <h1 class="text-xs font-bold uppercase tracking-wider">Register A2 - Bukti Pengeluaran Bidang Informatika
                        2025</h1>
                    <div class="flex gap-2">
                        <button type="submit" id="btn-save"
                            class="bg-white text-blue-800 px-3 py-1 rounded text-[10px] font-bold hover:bg-blue-50 transition-all">SIMPAN
                            DATA</button>
                        {{-- <button type="button" disabled title="Simpan data terlebih dahulu"
                            class="bg-gray-400 text-white px-3 py-1 rounded text-[10px] font-bold cursor-not-allowed">
                            CETAK DOKUMEN
                        </button> --}}

                    </div>
                </div>

                <div class="bg-white p-2 rounded border border-slate-300 shadow-sm">
                    <div class="grid grid-cols-3 gap-2 text-[10px] font-bold text-white">

                        {{-- TATA USAHA --}}
                        <div class="bg-green-700 p-1 rounded">
                            <label class="block mb-[2px] text-[9px] leading-none text-white">TATA USAHA</label>
                            <select name="tata_usaha"
                                class="w-full text-[9px] text-black rounded px-1 py-[1px] leading-none">
                                <option value="GU" {{ old('tata_usaha') == 'GU' ? 'selected' : '' }}>Ganti Uang (GU)
                                </option>
                                <option value="LS" {{ old('tata_usaha') == 'LS' ? 'selected' : '' }}>Langsung (LS)
                                </option>
                            </select>
                        </div>

                        {{-- JENIS A2 --}}
                        <div class="bg-green-700 p-1 rounded">
                            <label class="block mb-[1px] text-[8px] leading-none text-white">JENIS A2</label>
                            <select name="jenis_a2" class="w-full text-[9px] text-black rounded px-1 py-[1px] leading-none">
                                <option value="Non" {{ old('jenis_a2') == 'Non' ? 'selected' : '' }}>Non</option>
                                <option value="Cetak" {{ old('jenis_a2') == 'Cetak' ? 'selected' : '' }}>Cetak</option>
                            </select>
                        </div>

                        {{-- TRANSAKSI --}}
                        <div class="bg-green-700 p-1 rounded">
                            <label class="block mb-[1px] text-[8px] leading-none text-white">TRANSAKSI</label>
                            <select name="transaksi"
                                class="w-full text-[9px] text-black rounded px-1 py-[1px] leading-none">
                                <option value="BANK" {{ old('transaksi') == 'BANK' ? 'selected' : '' }}>BANK</option>
                                <option value="TUNAI" {{ old('transaksi') == 'TUNAI' ? 'selected' : '' }}>TUNAI</option>
                                <option value="KPPD" {{ old('transaksi') == 'KPPD' ? 'selected' : '' }}>KPPD</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-4 bg-white p-2 rounded border border-slate-300 shadow-sm">
                        <p class="text-[10px] font-bold text-blue-700 border-b mb-2 uppercase">Pengaturan DPA</p>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-600">Pilih DPA</label>
                                <select name="versi" id="versi"
                                    class="w-full border px-1 py-[2px] text-xs rounded bg-slate-50" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($versi as $v)
                                        <option value="{{ $v->id_versi_anggaran }}"
                                            {{ old('versi') == $v->id_versi_anggaran ? 'selected' : '' }}
                                            data-nomor="{{ $v->nomor_anggaran }}">
                                            {{ $v->id_versi_anggaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-600">Nomor DPA</label>
                                <input type="text" readonly id="no_dpa" name="no_dpa" value="{{ old('no_dpa') }}"
                                    class="w-full border px-1 py-[2px] text-xs rounded bg-slate-100 text-slate-500">
                            </div>
                        </div>
                    </div>

                    <div class="col-span-8 bg-white p-2 rounded border border-slate-300 shadow-sm">
                        <p class="text-[10px] font-bold text-blue-700 border-b mb-1 uppercase">Program, Kegiatan & Akun
                        </p>
                        <div class="grid grid-cols-2 gap-1">
                            <div class="col-span-1">
                                <label class="block text-[10px] font-semibold text-slate-600">Program / Kegiatan</label>
                                <select name="program" id="program" class="select-compact w-full" disabled>
                                    <option value="">-- Pilih Program --</option>
                                </select>
                                <input type="hidden" name="nama_program" id="nama_program">
                                <select name="kegiatan" id="kegiatan" class="select-compact w-full" disabled>
                                    <option value="">-- Pilih Kegiatan --</option>
                                </select>
                                <input type="hidden" name="nama_giat" id="nama_giat">

                            </div>
                            <div class="col-span-1">
                                <label class="block text-[10px] font-semibold text-slate-600">Sub Kegiatan - Akun
                                    Rekening</label>
                                <select name="sub_kegiatan" id="sub_kegiatan" class="select-compact w-full" disabled>
                                    <option value="">-- Pilih Sub Kegiatan --</option>
                                </select><select name="kode_akun" id="akun_rekening"
                                    class="w-full border px-1 py-[2px] text-[10px] rounded select-compact" disabled>
                                    <option value="">-- Pilih Akun --</option>
                                </select>
                                <input type="hidden" name="nama_akun" id="nama_akun">
                                <input type="hidden" name="nama_sub_giat" id="nama_sub_giat">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-5 bg-white p-2 rounded border border-slate-300 shadow-sm">

                        <p class="text-[10px] font-bold text-green-700 border-b mb-2 uppercase">Informasi Kegiatan</p>
                        <div class="grid gap-1">
                            <input type="date" name="tanggal" class="input-compact w-full" required>
                            <textarea id="keperluan" name="keperluan" rows="1" placeholder="Keperluan Pembayaran" class="text-[10px]"></textarea>
                        </div>
                        <p class="text-[10px] font-bold text-green-700 border-b mb-2 uppercase pt-3">Informasi Penerima</p>
                        <div class="grid grid-cols-2 gap-1">
                            <div class="col-span-2">
                                <select name="penerima" id="penerima"
                                    class="select-compact w-full bg-yellow-50 font-bold" onchange="isiDataPenerima()">
                                    <option value="">--- PILIH PENERIMA ---</option>
                                    @foreach ($penerima as $pn)
                                        <option value="{{ $pn->id }}" data-npwp="{{ $pn->npwp }}"
                                            data-bank="{{ $pn->bankpenerima }}" data-norek="{{ $pn->norek_penerima }}"
                                            data-nama="{{ $pn->penerima }}" data-alamat="{{ $pn->alamat }}">
                                            {{ $pn->penerima }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="nama_penerima" name="nama_penerima">
                            <input type="text" id="bank_penerima" name="bank_penerima" placeholder="Bank" readonly
                                class="input-compact bg-slate-50">
                            <input type="text" id="norek_penerima" name="norek_penerima" placeholder="No. Rekening"
                                readonly class="input-compact bg-slate-50">
                            <input type="text" id="npwp" name="npwp" placeholder="NPWP" readonly
                                class="input-compact bg-slate-50">
                            <input type="hidden" id="alamat_penerima" name="alamat_penerima">

                        </div>
                    </div>

                    <div class="col-span-7 bg-white p-2 rounded border border-slate-300 shadow-sm">
                        <p class="text-[10px] font-bold text-orange-700 border-b mb-2 uppercase">
                            Hitung Potongan PPh
                        </p>

                        <table class="w-full text-[10px] border mb-2">
                            <thead class="bg-yellow-800 text-white">
                                <tr>
                                    <th class="border px-1 py-[2px]">Jenis Golongan</th>
                                    <th class="border px-1 py-[2px]">Vol</th>
                                    <th class="border px-1 py-[2px]">Besaran</th>
                                    <th class="border px-1 py-[2px]">Pajak</th>
                                </tr>
                            </thead>
                            <tbody class="bg-yellow-100 font-bold">
                                <tr>
                                    <td class="border px-1 py-[2px]">Golongan IV</td>
                                    <td class="border px-1 py-[2px]"><input type="number" id="vol_iv"
                                            oninput="hitungPajakManual()" class="input-compact bg-slate-50"></td>
                                    <td class="border px-1 py-[2px]"><input type="number" id="besaran_iv"
                                            oninput="hitungPajakManual()" class="input-compact bg-slate-50"></td>
                                    <td class="border px-1 py-[2px] text-right" id="pajak_iv">0</td>
                                </tr>
                                <tr>
                                    <td class="border px-1 py-[2px]">Golongan III</td>
                                    <td class="border px-1 py-[2px]"><input type="number" id="vol_iii"
                                            oninput="hitungPajakManual()" class="input-compact bg-slate-50"></td>
                                    <td class="border px-1 py-[2px]"><input type="number" id="besaran_iii"
                                            oninput="hitungPajakManual()" class="input-compact bg-slate-50"></td>
                                    <td class="border px-1 py-[2px] text-right" id="pajak_iii">0</td>
                                </tr>
                                <tr>
                                    <td class="border px-1 py-[2px]">Pihak Lain</td>
                                    <td class="border px-1 py-[2px]"><input type="number" id="vol_lain"
                                            oninput="hitungPajakManual()" class="input-compact bg-slate-50"></td>
                                    <td class="border px-1 py-[2px]"><input type="number" id="besaran_lain"
                                            oninput="hitungPajakManual()" class="input-compact bg-slate-50"></td>
                                    <td class="border px-1 py-[2px] text-right" id="pajak_lain">0</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="w-full text-[10px] border" id="tabel_pajak">
                            <thead class="bg-red-800 text-white">
                                <tr>
                                    <th class="border px-1 py-[2px]">Potongan Pajak</th>
                                    <th class="border px-1 py-[2px]">Nominal</th>
                                    <th class="border px-1 py-[2px]">Kode</th>
                                    <th class="border px-1 py-[2px]">+</th>
                                </tr>
                            </thead>

                            <tbody id="body_pajak" class="bg-red-100 font-bold text-center">
                                <!-- BARIS PERTAMA -->
                                <tr class="pajak-row">
                                    <td class="border px-1 py-[2px]">
                                        <select name="pajak[kode][]" class="w-full text-[9px]" onchange="hitungPajakBaris(this)">
                                            <option value="">-- Pilih Pajak --</option>
                                            @foreach ($dpp as $p)
                                                <option value="{{ $p->kode_potongan }}" data-jenis="{{ $p->jenis_pajak }}">
                                                    {{ $p->jenis_potongan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="border px-1 py-[2px]">
                                        <input type="text" name="pajak[nominal][]"
                                            class="w-full text-right text-[9px] bg-gray-100" value="0" readonly>
                                        <input type="hidden" name="pajak[jenis][]">
                                    </td>

                                    <td class="border px-1 py-[2px] kode-pajak">-</td>

                                    <td class="border px-1 py-[2px]">
                                        <button type="button" onclick="tambahPajak()"
                                            class="bg-green-600 text-white px-2 py-1 rounded text-[9px]">
                                            +
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                </div>

                <div class="grid grid-cols-12 gap-2">
                    <div
                        class="col-span-3 bg-blue-50 p-2 rounded border border-blue-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-blue-800 border-b border-blue-200 mb-1 uppercase">Total
                                Dibayarkan</p>
                            <div class="space-y-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-slate-500">BRUTO:</span>
                                    <input type="text" id="bruto" name="bruto" readonly
                                        class="w-24 text-right bg-transparent border-none p-0 text-[11px] font-bold">
                                </div>
                                <div class="flex justify-between items-center text-red-600">
                                    <span class="text-[9px]">PAJAK:</span>
                                    <input type="text" id="pajakPotong" name="pajakPotong" readonly
                                        class="w-24 text-right bg-transparent border-none p-0 text-[11px] font-bold">
                                </div>
                                <div class="flex justify-between items-center text-green-700 border-t pt-1">
                                    <span class="text-[10px] font-bold">NETTO:</span>
                                    <input type="text" id="netto" name="nom_netto" readonly
                                        class="w-24 text-right bg-transparent border-none p-0 text-sm font-black">
                                </div>
                            </div>
                        </div>
                        <textarea id="terbilang" rows="2" readonly name="netto_terbilang"
                            class="mt-2 w-full text-[9px] bg-white italic px-1 py-[2px] border rounded text-slate-600 leading-tight"
                            placeholder="Terbilang..."></textarea>
                    </div>

                    <div class="col-span-9 bg-white rounded border border-slate-300 shadow-sm">
                        <div class="max-h-[160px] overflow-y-auto overflow-x-auto scrollbar-thin">
                            <table class="w-full table-compact leading-tight">
                                <thead class="bg-slate-800 text-white sticky top-0">
                                    <tr>
                                        <th rowspan="2" class="px-[2px] py-[1px] border text-[9px]">ID</th>
                                        <th rowspan="2" class="px-[2px] py-[1px] border text-[9px]">Uraian Komponen
                                        </th>
                                        <th rowspan="2" class="px-[2px] py-[1px] border text-[9px]">Satuan</th>
                                        <th colspan="3" class="px-[2px] py-[1px] border text-[9px] bg-blue-700">Rincian
                                            Anggaran</th>
                                        <th colspan="3" class="px-[2px] py-[1px] border text-[9px] bg-green-700">
                                            Pengeluaran Riil</th>
                                        <th colspan="4" class="px-[2px] py-[1px] border text-[9px] bg-indigo-700">
                                            Informasi
                                            Komponen</th>
                                    </tr>
                                    <tr>
                                        <!-- Rincian Anggaran -->
                                        <th class="px-1 py-[2px] border">Vol</th>
                                        <th class="px-1 py-[2px] border">Harga</th>
                                        <th class="px-1 py-[2px] border">Total</th>

                                        <!-- Riil -->
                                        <th class="px-1 py-[2px] border">Vol</th>
                                        <th class="px-1 py-[2px] border">Harga</th>
                                        <th class="px-1 py-[2px] border">Nominal</th>

                                        <!-- Info -->
                                        <th class="px-1 py-[2px] border">Reg Vol</th>
                                        <th class="px-1 py-[2px] border">Reg Nom</th>
                                        <th class="px-1 py-[2px] border">Sisa Vol</th>
                                        <th class="px-1 py-[2px] border">Sisa Nom</th>
                                    </tr>
                                </thead>

                                <tbody id="tabelRincian" class="divide-y divide-slate-200">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="hasilPph" name="hasilPph">
                <div class="grid grid-cols-12 gap-2 mt-2">
            </form>
        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /* =========================
                HELPER RESET SELECT
                ========================== */
                function resetSelect(id, placeholder) {
                    let el = document.getElementById(id);
                    el.innerHTML = `<option value="">${placeholder}</option>`;
                    el.disabled = true;
                }

                /* =========================
                VERSI / DPA
                ========================== */
                document.getElementById('versi').addEventListener('change', function() {

                    console.log('CHANGE TRIGGERED');

                    let opt = this.options[this.selectedIndex];
                    console.log('DATA NOMOR:', opt.dataset.nomor);

                    let nomor = this.options[this.selectedIndex]?.dataset.nomor;
                    document.getElementById('no_dpa').value = nomor ?? '';

                    let versi = this.value;

                    setLoadingSelect('program', 'Memuat Program...');
                    resetSelect('kegiatan', '-- Pilih Kegiatan --');
                    resetSelect('sub_kegiatan', '-- Pilih Sub Kegiatan --');
                    resetSelect('akun_rekening', '-- Pilih Akun --');

                    if (!versi) return;

                    fetch(`/a2/program-by-dpa/${versi}`)
                        .then(res => res.json())
                        .then(data => {
                            let program = document.getElementById('program');
                            program.innerHTML = `<option value="">-- Pilih Program --</option>`;
                            program.disabled = false;

                            data.forEach(p => {
                                let opt = document.createElement('option');
                                opt.value = p.kode_program;
                                opt.textContent = p.nama_program;
                                program.appendChild(opt);
                            });
                        });
                });


                /* =========================
                PROGRAM
                ========================== */
                document.getElementById('program').addEventListener('change', function() {

                    const selected = this.options[this.selectedIndex];
                    document.getElementById('nama_program').value = selected ? selected.textContent.trim() : '';

                    let programId = this.value;

                    setLoadingSelect('kegiatan', 'Memuat Kegiatan...');
                    resetSelect('sub_kegiatan', '-- Pilih Sub Kegiatan --');
                    resetSelect('akun_rekening', '-- Pilih Akun --');

                    if (!programId) return;

                    fetch(`/a2/kegiatan-by-program/${programId}`)
                        .then(res => res.json())
                        .then(data => {
                            let kegiatan = document.getElementById('kegiatan');
                            kegiatan.innerHTML = `<option value="">-- Pilih Kegiatan --</option>`;
                            kegiatan.disabled = false;

                            data.forEach(k => {
                                let opt = document.createElement('option');
                                opt.value = k.kode_giat;
                                opt.textContent = k.nama_giat;
                                kegiatan.appendChild(opt);
                            });
                        });
                });


                /* =========================
                KEGIATAN
                ========================== */
                document.getElementById('kegiatan').addEventListener('change', function() {

                    const selected = this.options[this.selectedIndex];
                    document.getElementById('nama_giat').value = selected ? selected.textContent.trim() : '';

                    let kegiatanId = this.value;

                    setLoadingSelect('sub_kegiatan', 'Memuat Sub Kegiatan...');
                    resetSelect('akun_rekening', '-- Pilih Akun --');

                    if (!kegiatanId) return;

                    fetch(`/a2/subkegiatan-by-kegiatan/${kegiatanId}`)
                        .then(res => res.json())
                        .then(data => {
                            let sub = document.getElementById('sub_kegiatan');
                            sub.innerHTML = `<option value="">-- Pilih Sub Kegiatan --</option>`;
                            sub.disabled = false;

                            data.forEach(s => {
                                let opt = document.createElement('option');
                                opt.value = s.kode_sub_giat;
                                opt.textContent = s.nama_sub_giat;
                                sub.appendChild(opt);
                            });
                        });
                });

                /* =========================
                SUB KEGIATAN
                ========================== */
                document.getElementById('sub_kegiatan').addEventListener('change', function() {

                    const selected = this.options[this.selectedIndex];
                    document.getElementById('nama_sub_giat').value = selected ? selected.textContent.trim() :
                        '';

                    let sub = this.value;

                    setLoadingSelect('akun_rekening', 'Memuat Akun...');

                    if (!sub) return;

                    fetch(`/a2/akun-by-subkegiatan/${sub}`)
                        .then(res => res.json())
                        .then(data => {
                            let akun = document.getElementById('akun_rekening');
                            akun.innerHTML = `<option value="">-- Pilih Akun --</option>`;
                            akun.disabled = false;

                            data.forEach(a => {
                                let opt = document.createElement('option');
                                opt.value = a.kode_akun;
                                opt.textContent = `${a.kode_akun} - ${a.nama_akun}`;
                                akun.appendChild(opt);
                            });
                        });
                });

                /* =========================
                AKUN → RINCIAN
                ========================== */
                document.getElementById('akun_rekening').addEventListener('change', function() {

                    const selected = this.options[this.selectedIndex];
                    if (!selected) {
                        document.getElementById('nama_akun').value = '';
                        return;
                    }

                    const text = selected.textContent;
                    const nama = text.split(' - ').slice(1).join(' - ');

                    document.getElementById('nama_akun').value = nama.trim();

                    let akun = this.value;
                    let versi = document.getElementById('versi').value;
                    let program = document.getElementById('program').value;
                    let kegiatan = document.getElementById('kegiatan').value;
                    let sub = document.getElementById('sub_kegiatan').value;

                    if (!akun || !versi || !program || !kegiatan || !sub) {
                        document.getElementById('tabelRincian').innerHTML = '';
                        return;
                    }

                    fetch(`/a2/filter-rincian`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                versi,
                                program,
                                kegiatan,
                                sub_kegiatan: sub,
                                akun
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            let html = data.map((row, i) => `
    <tr>
        <td class="px-1 py-[2px] border text-center">${row.id_rinci_sub_bl}</td>
        <td class="px-1 py-[2px] border">${row.nama_komponen}</td>
        <td class="px-1 py-[2px] border text-center">${row.satuan}</td>

        <!-- RENCANA -->
        <td class="px-1 py-[2px] border text-center">${row.volume}</td>
        <td class="px-1 py-[2px] border text-right">${Number(row.harga_satuan).toLocaleString('id-ID')}</td>
        <td class="px-1 py-[2px] border text-right font-bold">
            ${(row.volume * row.harga_satuan).toLocaleString('id-ID')}
        </td>

        <!-- RIIL -->
        <td class="px-1 py-[2px] border">
            <input type="number"
                name="riil[${i}][vol]"
        class="w-12 border text-[9px] p-0"
                oninput="hitungRiilBaris(${i})">
        </td>
        <td class="px-1 py-[2px] border">
            <input type="text"
                name="riil[${i}][harga]"
        class="w-16 border text-[9px] p-0 text-right"
                oninput="hitungRiilBaris(${i})"
                onfocus="unformatNumber(this)"
                onblur="formatNumber(this)">
        </td>
        <td class="px-1 py-[2px] border text-right font-bold text-green-700">
            <input type="text"
                readonly
                id="nominal_riil_${i}"
        class="w-20 text-right bg-green-50 border-none font-bold text-[9px]">
        </td>

        <!-- INFO -->
        <td class="px-1 py-[2px] border text-center text-slate-600">${row.reg_sah_vol}</td>
        <td class="px-1 py-[2px] border text-right text-slate-600">
            ${Number(row.reg_sah_nom).toLocaleString('id-ID')}
        </td>
        <td class="px-1 py-[2px] border text-center text-red-600 font-bold">${row.sisa_vol}</td>
        <td class="px-1 py-[2px] border text-right text-red-600 font-bold">
            ${Number(row.sisa_nom).toLocaleString('id-ID')}
        </td>

        <!-- HIDDEN WAJIB -->
        <input type="hidden" name="riil[${i}][id_rinci_sub_bl]" value="${row.id_rinci_sub_bl}">
        <input type="hidden" name="riil[${i}][nama_komponen]" value="${row.nama_komponen}">
        <input type="hidden" name="riil[${i}][kode_dana]" value="${row.kode_dana}">
        <input type="hidden" name="riil[${i}][nama_dana]" value="${row.nama_dana}">
        <input type="hidden" name="riil[${i}][kode_skpd]" value="${row.kode_skpd}">
        <input type="hidden" name="riil[${i}][nama_skpd]" value="${row.nama_skpd}">
        <input type="hidden" name="riil[${i}][pptk_id]" value="${row.pptk_id}">
        <input type="hidden" name="riil[${i}][pokja_id]" value="${row.pokja_id}">
    </tr>
    `).join('');


                            document.getElementById('tabelRincian').innerHTML = html;
                        });
                });

            });

            // Penerima Logic
            function isiDataPenerima() {
                let select = document.getElementById('penerima');
                let option = select.options[select.selectedIndex];
                document.getElementById('nama_penerima').value = option.getAttribute('data-nama') || '';
                document.getElementById('npwp').value = option.getAttribute('data-npwp') || '';
                document.getElementById('bank_penerima').value = option.getAttribute('data-bank') || '';
                document.getElementById('norek_penerima').value = option.getAttribute('data-norek') || '';
                document.getElementById('alamat_penerima').value = option.getAttribute('data-alamat') || '';
            }

            function setLoadingSelect(id, text = 'Memuat...') {
                let el = document.getElementById(id);
                el.innerHTML = `<option value="">${text}</option>`;
                el.disabled = true;
            }

            function hitungRiilBaris(i) {
                const vol = Number(document.querySelector(`input[name="riil[${i}][vol]"]`)?.value || 0);
                const harga = parseRupiah(
                    document.querySelector(`input[name="riil[${i}][harga]"]`)?.value || 0
                );

                const total = vol * harga;

                document.getElementById(`nominal_riil_${i}`).value =
                    total > 0 ? formatRupiah(total) : '';

                hitungBruto();
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

            // function formatNumber(el) {
            //     if (!el.value) return;
            //     el.value = parseInt(el.value.replace(/\D/g, '')).toLocaleString('id-ID');
            // }

            /* =========================
            FORMAT & PARSE RUPIAH
            ========================= */
            function parseRupiah(val) {
                if (!val) return 0;

                return parseFloat(
                    val.toString()
                    .replace(/\./g, '') // hapus ribuan
                    .replace(',', '.') // koma → desimal
                    .replace(/[^0-9.]/g, '')
                ) || 0;
            }

            function formatRupiah(num) {
                return Number(num || 0).toLocaleString('id-ID');
            }

            function hitungBruto() {
                let total = 0;

                document.querySelectorAll('[id^="nominal_riil_"]').forEach(el => {
                    total += parseRupiah(el.value);
                });

                document.getElementById('bruto').value = formatRupiah(total);

                hitungNetto(); // lanjut ke netto
            }

            function hitungPajak() {
                const kode = document.getElementById('dpp_select')?.value;

                if (!kode) {
                    document.getElementById('pph_nominal').innerText = 0;
                    document.getElementById('pph_kode').innerText = '-';
                    document.getElementById('pajakPotong').value = 0;
                    hitungNetto();
                    return;
                }

                const bruto = parseRupiah(document.getElementById('bruto').value);

                // Pajak manual golongan
                const iv = (Number(vol_iv.value) || 0) * (Number(besaran_iv.value) || 0) * 0.15;
                const iii = (Number(vol_iii.value) || 0) * (Number(besaran_iii.value) || 0) * 0.05;
                const lain = (Number(vol_lain.value) || 0) * (Number(besaran_lain.value) || 0) * 0.06;

                pajak_iv.innerText = iv ? formatRupiah(iv) : 0;
                pajak_iii.innerText = iii ? formatRupiah(iii) : 0;
                pajak_lain.innerText = lain ? formatRupiah(lain) : 0;

                let nominal = 0;
                const dpp = Math.ceil((100 / 111) * bruto);

                switch (kode) {

                    case '411121-402':
                        nominal = iv + iii + lain;
                        break;

                    case '411121-21-100-20':
                        nominal = 0.05 * dpp;
                        break;

                    case '411122-920':
                        nominal = 0.015 * dpp;
                        break;

                    case '411124-100':
                    case '411124-104':
                        nominal = 0.02 * dpp;
                        break;

                    case '411211-920':
                        nominal = 0.12 * (11 / 12 * dpp);
                        break;

                    case '999999-100':
                        nominal = 0.10 * bruto;
                        break;

                    default:
                        nominal = 0;
                }

                nominal = Math.ceil(nominal);

                document.getElementById('pph_nominal').innerText =
                    nominal ? formatRupiah(nominal) : 0;

                document.getElementById('pph_kode').innerText = kode;
                document.getElementById('pajakPotong').value = nominal;

                hitungNetto();
            }

            function hitungNetto() {
                const bruto = parseRupiah(document.getElementById('bruto').value);
                const pajak = parseRupiah(document.getElementById('pajakPotong').value);

                const netto = bruto - pajak;

                document.getElementById('netto').value = formatRupiah(netto);
                document.getElementById('terbilang').value =
                    netto > 0 ? terbilang(netto) + ' Rupiah' : '';
            }

            function terbilangInt(n) {
                n = Math.floor(n);

                const angka = ["", "Satu", "Dua", "Tiga", "Empat", "Lima",
                    "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
                ];

                if (n < 12) return angka[n];
                if (n < 20) return terbilangInt(n - 10) + " Belas";
                if (n < 100) return terbilangInt(Math.floor(n / 10)) + " Puluh " + terbilangInt(n % 10);
                if (n < 200) return "Seratus " + terbilangInt(n - 100);
                if (n < 1000) return terbilangInt(Math.floor(n / 100)) + " Ratus " + terbilangInt(n % 100);
                if (n < 2000) return "Seribu " + terbilangInt(n - 1000);
                if (n < 1000000) return terbilangInt(Math.floor(n / 1000)) + " Ribu " + terbilangInt(n % 1000);
                if (n < 1000000000) return terbilangInt(Math.floor(n / 1000000)) + " Juta " + terbilangInt(n % 1000000);

                return "";
            }

            function terbilang(n) {
                n = Number(n);

                if (isNaN(n)) return "";

                const rupiah = Math.floor(n);
                const sen = Math.round((n - rupiah) * 100);

                let hasil = terbilangInt(rupiah);

                if (sen > 0) {
                    hasil += " " + terbilangInt(sen) + " Sen";
                }

                return hasil.trim();
            }

            function hitungPajakManual() {
                // hanya update tampilan per golongan
                const iv = (Number(vol_iv.value) || 0) * (Number(besaran_iv.value) || 0) * 0.15;
                const iii = (Number(vol_iii.value) || 0) * (Number(besaran_iii.value) || 0) * 0.05;
                const lain = (Number(vol_lain.value) || 0) * (Number(besaran_lain.value) || 0) * 0.06;

                pajak_iv.innerText = iv ? formatRupiah(iv) : 0;
                pajak_iii.innerText = iii ? formatRupiah(iii) : 0;
                pajak_lain.innerText = lain ? formatRupiah(lain) : 0;
            }

            function tambahPajak() {
                const body = document.getElementById('body_pajak');
                const rows = body.querySelectorAll('.pajak-row');

                if (rows.length >= 2) {
                    alert('Maksimal 2 pajak');
                    return;
                }

                const clone = rows[0].cloneNode(true);

                clone.querySelector('select').value = '';
                clone.querySelector('input[name="pajak[nominal][]"]').value = 0;

                const kodeCell = clone.querySelector('.kode-pajak');
                if (kodeCell) kodeCell.innerText = '-';

                clone.querySelector('button').outerHTML = `
        <button type="button"
            onclick="hapusPajak(this)"
            class="bg-red-600 text-white px-2 py-1 rounded text-[9px]">
            -
        </button>`;

                body.appendChild(clone);
            }


            function hapusPajak(btn) {
                btn.closest('.pajak-row').remove();
            }

            function hitungPajakBaris(select) {
                const row = select.closest('tr');
                const kode = select.value;

                // ✅ ambil jenis_pajak dari option
                const selectedOption = select.options[select.selectedIndex];
                const jenisPajak = selectedOption?.dataset?.jenis || '';

                // ✅ set ke hidden input
                row.querySelector('input[name="pajak[jenis][]"]').value = jenisPajak;

                const bruto = parseRupiah(document.getElementById('bruto')?.value || 0);
                const dpp = Math.ceil((100 / 111) * bruto);

                let nominal = 0;

                switch (kode) {
                    case '411121-402':
                        const iv = (Number(vol_iv.value) || 0) * (Number(besaran_iv.value) || 0) * 0.15;
                        const iii = (Number(vol_iii.value) || 0) * (Number(besaran_iii.value) || 0) * 0.05;
                        const lain = (Number(vol_lain.value) || 0) * (Number(besaran_lain.value) || 0) * 0.06;
                        nominal = iv + iii + lain;
                        break;

                    case '411121-21-100-20':
                        nominal = 0.05 * dpp;
                        break;

                    case '411122-920':
                        nominal = 0.015 * dpp;
                        break;

                    case '411124-100':
                    case '411124-104':
                        nominal = 0.02 * dpp;
                        break;

                    case '411211-920':
                        nominal = 0.12 * (11 / 12 * dpp);
                        break;

                    case '999999-100':
                        nominal = 0.10 * bruto;
                        break;

                    default:
                        nominal = 0;
                }

                nominal = Math.ceil(nominal);

                // ✅ SET INPUT (BUKAN INNER TEXT)
                row.querySelector('input[name="pajak[nominal][]"]').value = nominal;

                // ✅ SET KODE
                const kodeCell = row.querySelector('.kode-pajak');
                if (kodeCell) kodeCell.innerText = kode || '-';

                hitungTotalPajak();
            }


            function hitungTotalPajak() {
                let total = 0;

                document.querySelectorAll('input[name="pajak[nominal][]"]').forEach(el => {
                    total += parseRupiah(el.value || 0);
                });

                document.getElementById('pajakPotong').value = total;
                hitungNetto();
            }
        </script>
    @endpush
