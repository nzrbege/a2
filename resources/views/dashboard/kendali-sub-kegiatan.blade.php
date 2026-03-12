@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Dashboard Cek Kendali Anggaran
                </h1>

                <p class="text-sm text-gray-500">
                    Diskominfo Kabupaten Klaten - Tahun 2025
                </p>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Refresh
            </button>

        </div>


        <!-- FILTER -->
        <div class="bg-white shadow rounded-xl border p-4">

            <div class="grid md:grid-cols-3 gap-4">

                <select id="program" name="program" class="w-full">
                    <option>Pilih Program</option>
                    @foreach ($programs as $p)
                        <option value="{{ $p->kode_program }}">
                            {{ $p->nama_program }}
                        </option>
                    @endforeach
                </select>

                <select name="kegiatan" id="kegiatan" class="w-full">
                    <option>Pilih Kegiatan</option>
                </select>

                <select id="sub_kegiatan" name="sub_kegiatan" class="w-full">
                    <option>Pilih Sub Kegiatan</option>
                </select>

            </div>

        </div>


        <!-- SUMMARY -->
        <div class="grid md:grid-cols-4 gap-4">

            <div class="bg-white border shadow rounded-xl p-4">
                <p class="text-xs text-gray-500">Total Anggaran</p>
                <p class="text-xl font-bold text-gray-700">
                    Rp {{ number_format($total_anggaran) }}
                </p>
            </div>

            <div class="bg-white border shadow rounded-xl p-4">
                <p class="text-xs text-gray-500">SPD TW I</p>
                <p class="text-xl font-bold text-blue-600">
                    Rp {{ number_format($total_spd) }}
                </p>
            </div>

            <div class="bg-white border shadow rounded-xl p-4">
                <p class="text-xs text-gray-500">Realisasi</p>
                <p class="text-xl font-bold text-green-600">
                    Rp {{ number_format($total_realisasi) }}
                </p>
            </div>

            <div class="bg-white border shadow rounded-xl p-4">
                <p class="text-xs text-gray-500">Sisa Anggaran</p>
                <p class="text-xl font-bold text-red-600">
                    Rp {{ number_format($total_sisa_anggaran) }}
                </p>
            </div>

        </div>


        <!-- CONTENT -->
        <div class="grid lg:grid-cols-3 gap-6">

            <!-- INFO SUB KEGIATAN -->
            <div class="bg-white border shadow rounded-xl p-5 space-y-3">

                <h3 class="font-semibold text-gray-700">
                    Informasi Sub Kegiatan
                </h3>

                <div>
                    <p class="text-xs text-gray-400">Program</p>
                    <p class="font-semibold">                        
                        <input type="text" name="nama_program" id="nama_program" readonly>
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Kegiatan</p>
                    <p>
                        <input type="text" name="nama_giat" id="nama_giat" readonly>
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Sub Kegiatan</p>
                    <p class="font-semibold text-green-600">
                        <input type="text" name="nama_sub_giat" id="nama_sub_giat" readonly>
                    </p>
                </div>

            </div>


            <!-- TABEL -->
            <div class="lg:col-span-2 bg-white border shadow rounded-xl overflow-hidden">

                <table class="w-full text-sm">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Kode</th>
                            <th class="p-3 text-left">Uraian</th>
                            <th class="p-3 text-right">Anggaran</th>
                            <th class="p-3 text-right">SPD</th>
                            <th class="p-3 text-right text-green-700">Sah</th>
                            <th class="p-3 text-right text-yellow-600">Pending</th>
                            <th class="p-3 text-right">Sisa</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @foreach ($data as $row)
                            <tr class="hover:bg-gray-50">

                                <td class="p-2 font-mono text-blue-600">
                                    {{ $row->kode_akun }}
                                </td>

                                <td class="p-2">
                                    {{ $row->uraian }}
                                </td>

                                <td class="p-2 text-right">
                                    {{ number_format($row->anggaran) }}
                                </td>

                                <td class="p-2 text-right">
                                    {{ number_format($row->spd) }}
                                </td>

                                <td class="p-2 text-right text-green-600">
                                    {{ number_format($row->realisasi_sah) }}
                                </td>

                                <td class="p-2 text-right text-yellow-600">
                                    {{ number_format($row->pending) }}
                                </td>

                                <td class="p-2 text-right font-semibold">
                                    {{ number_format($row->sisa_anggaran) }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('program').addEventListener('change', function() {

                const selected = this.options[this.selectedIndex];
                document.getElementById('nama_program').value = selected ? selected.textContent.trim() : '';

                let programId = this.value;

                setLoadingSelect('kegiatan', 'Memuat Kegiatan...');
                resetSelect('sub_kegiatan', '-- Pilih Sub Kegiatan --');

                if (!programId) return;

                fetch(`/a2/kegiatan-by-program/${programId}`)
                    .then(res => {
                        if (!res.ok) throw new Error('Server error');
                        return res.json()
                    })
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
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Gagal memuat data');
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
                    // resetSelect('akun_rekening', '-- Pilih Akun --');

                    if (!kegiatanId) return;

                    fetch(`/a2/subkegiatan-by-kegiatan/${kegiatanId}`)
                        .then(res => {
                            if (!res.ok) throw new Error('Server error');
                            return res.json()
                        })
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
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Gagal memuat data');
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
                        .then(res => {
                            if (!res.ok) throw new Error('Server error');
                            return res.json()
                        })
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
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Gagal memuat data');
                        });
                });
        });

        function setLoadingSelect(id, text = 'Memuat...') {
            let el = document.getElementById(id);
            el.innerHTML = `<option value="">${text}</option>`;
            el.disabled = true;
        }

        function resetSelect(id, placeholder) {
            let el = document.getElementById(id);
            el.innerHTML = `<option value="">${placeholder}</option>`;
            el.disabled = true;
        }
    </script>
@endpush
