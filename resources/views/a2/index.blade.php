@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4">

        {{-- ── HEADER ── --}}
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-base font-bold text-slate-800 uppercase tracking-wide">Daftar Register A2</h1>
                <p class="text-xs text-slate-400 mt-0.5">Bukti Pengeluaran Bidang Informatika {{ date('Y') }}</p>
            </div>
            <a href="{{ route('a2.create') }}"
                class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold rounded-lg shadow transition-colors">
                <i class="bi bi-plus-lg"></i> Tambah Register
            </a>
        </div>

        {{-- ── ALERT SUCCESS ── --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="mb-3 flex items-center justify-between gap-3 px-4 py-2.5 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false"
                    class="text-green-500 hover:text-green-700 text-lg leading-none">&times;</button>
            </div>
        @endif

        {{-- ── ALERT ERROR ── --}}
        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="mb-3 flex items-center justify-between gap-3 px-4 py-2.5 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <div class="flex items-center gap-2">
                    <i class="bi bi-exclamation-circle-fill text-red-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-red-500 hover:text-red-700 text-lg leading-none">&times;</button>
            </div>
        @endif

        {{-- ── FILTER BAR ── --}}
        <form method="GET" action="{{ route('a2.index') }}"
            class="mb-4 bg-white border border-slate-200 rounded-lg px-4 py-3 shadow-sm flex flex-wrap gap-3 items-end">

            <input type="hidden" name="sort" value="{{ request('sort') }}">
            <input type="hidden" name="order" value="{{ request('order') }}">

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Cari Global</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="No / Rekening / Keperluan"
                    class="border border-slate-300 rounded-md px-3 py-1.5 text-xs w-56 focus:outline-none focus:ring-1 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Tanggal Dari</label>
                <input type="date" name="tgl_dari" value="{{ request('tgl_dari') }}"
                    class="border border-slate-300 rounded-md px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Tanggal Sampai</label>
                <input type="date" name="tgl_sampai" value="{{ request('tgl_sampai') }}"
                    class="border border-slate-300 rounded-md px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="px-3 py-1.5 bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold rounded-md transition-colors">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
                <a href="{{ route('a2.index') }}"
                    class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-md transition-colors">
                    Reset
                </a>
            </div>

            {{-- Info jumlah hasil --}}
            <div class="ml-auto text-xs text-slate-400 self-center">
                {{ $registers->total() }} data ditemukan
            </div>

        </form>

        {{-- ── TABEL ── --}}
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs border-collapse">
                    <thead>

                        {{-- Baris 1: nama kolom + sort --}}
                        <tr class="bg-slate-800 text-white text-left">
                            <th class="px-3 py-2.5 border border-slate-700 w-10 text-center">#</th>

                            @php
                                $cols = [
                                    'gen_no_reg' => 'No Register',
                                    'urai_subkeg' => 'Sub Kegiatan',
                                    'urai_rekbel' => 'Rekening Belanja',
                                    'keperluan' => 'Keperluan',
                                    'nom_bruto' => 'Nominal',
                                ];
                                $currentSort = request('sort', 'gen_no_reg');
                                $currentOrder = request('order', 'asc');
                            @endphp

                            @foreach ($cols as $field => $label)
                                @php
                                    $nextOrder = $currentSort === $field && $currentOrder === 'asc' ? 'desc' : 'asc';
                                    $isActive = $currentSort === $field;
                                    $icon = $isActive
                                        ? ($currentOrder === 'asc'
                                            ? 'bi-sort-up'
                                            : 'bi-sort-down')
                                        : 'bi-arrow-down-up';
                                    $align = $field === 'nom_bruto' ? 'text-right' : 'text-left';
                                @endphp
                                <th class="px-3 py-2.5 border border-slate-700 {{ $align }} whitespace-nowrap">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => $field, 'order' => $nextOrder]) }}"
                                        class="inline-flex items-center gap-1 {{ $isActive ? 'text-yellow-300' : 'text-white hover:text-yellow-200' }} transition-colors">
                                        {{ $label }}
                                        <i class="bi {{ $icon }} text-xs"></i>
                                    </a>
                                </th>
                            @endforeach

                            <th class="px-3 py-2.5 border border-slate-700 text-center w-28">Aksi</th>
                        </tr>

                        {{-- Baris 2: search per kolom --}}
                        <form method="GET" action="{{ route('a2.index') }}" id="col-search-form">
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                            <input type="hidden" name="order" value="{{ request('order') }}">
                            <input type="hidden" name="tgl_dari" value="{{ request('tgl_dari') }}">
                            <input type="hidden" name="tgl_sampai"value="{{ request('tgl_sampai') }}">
                            <tr class="bg-slate-700">
                                <th class="px-1 py-1 border border-slate-600"></th>
                                <th class="px-1 py-1 border border-slate-600">
                                    <input type="text" name="f_no_reg" value="{{ request('f_no_reg') }}"
                                        placeholder="Cari no..."
                                        class="w-full text-xs rounded px-1.5 py-1 bg-slate-600 text-white placeholder-slate-400 border border-slate-500 focus:outline-none focus:ring-1 focus:ring-yellow-400">
                                </th>
                                <th class="px-1 py-1 border border-slate-600">
                                    <input type="text" name="f_subkeg" value="{{ request('f_subkeg') }}"
                                        placeholder="Cari sub kegiatan..."
                                        class="w-full text-xs rounded px-1.5 py-1 bg-slate-600 text-white placeholder-slate-400 border border-slate-500 focus:outline-none focus:ring-1 focus:ring-yellow-400">
                                </th>
                                <th class="px-1 py-1 border border-slate-600">
                                    <input type="text" name="f_rekbel" value="{{ request('f_rekbel') }}"
                                        placeholder="Cari rekening..."
                                        class="w-full text-xs rounded px-1.5 py-1 bg-slate-600 text-white placeholder-slate-400 border border-slate-500 focus:outline-none focus:ring-1 focus:ring-yellow-400">
                                </th>
                                <th class="px-1 py-1 border border-slate-600">
                                    <input type="text" name="f_keperluan" value="{{ request('f_keperluan') }}"
                                        placeholder="Cari keperluan..."
                                        class="w-full text-xs rounded px-1.5 py-1 bg-slate-600 text-white placeholder-slate-400 border border-slate-500 focus:outline-none focus:ring-1 focus:ring-yellow-400">
                                </th>
                                <th class="px-1 py-1 border border-slate-600">
                                    <input type="text" name="f_nominal" value="{{ request('f_nominal') }}"
                                        placeholder="Cari nominal..."
                                        class="w-full text-xs rounded px-1.5 py-1 bg-slate-600 text-white placeholder-slate-400 border border-slate-500 focus:outline-none focus:ring-1 focus:ring-yellow-400 text-right">
                                </th>
                                <th class="px-1 py-1 border border-slate-600 text-center">
                                    <button type="submit"
                                        class="px-2 py-1 bg-yellow-500 hover:bg-yellow-400 text-slate-900 text-xs font-bold rounded transition-colors">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </th>
                            </tr>
                        </form>

                    </thead>

                    <tbody>
                        @forelse ($registers as $i => $r)
                            <tr
                                class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-slate-50' }} hover:bg-blue-50 transition-colors">

                                <td class="px-3 py-2 border border-slate-100 text-center text-slate-400 font-medium">
                                    {{ $registers->firstItem() + $i }}
                                </td>

                                <td
                                    class="px-3 py-2 border border-slate-100 font-semibold text-blue-700 whitespace-nowrap">
                                    {{ $r->gen_no_reg }}
                                </td>

                                <td class="px-3 py-2 border border-slate-100 text-slate-600 max-w-xs">
                                    <span class="line-clamp-2"
                                        title="{{ $r->urai_subkeg }}">{{ $r->urai_subkeg }}</span>
                                </td>

                                <td class="px-3 py-2 border border-slate-100 text-slate-600">
                                    <span class="line-clamp-2"
                                        title="{{ $r->urai_rekbel }}">{{ $r->urai_rekbel }}</span>
                                </td>

                                <td class="px-3 py-2 border border-slate-100 text-slate-600 max-w-xs">
                                    <span class="line-clamp-2" title="{{ $r->keperluan }}">{{ $r->keperluan }}</span>
                                </td>

                                <td
                                    class="px-3 py-2 border border-slate-100 text-right font-semibold text-slate-800 whitespace-nowrap">
                                    Rp {{ number_format($r->nom_bruto, 0, ',', '.') }}
                                </td>

                                <td class="px-3 py-2 border border-slate-100">
                                    <div class="flex justify-center items-center gap-1">
                                        <a href="{{ route('a2.show', $r->id_reg) }}" title="Lihat Detail"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-indigo-600 hover:bg-indigo-700 text-white rounded transition-colors">
                                            <i class="bi bi-eye text-xs"></i>
                                        </a>

                                        <a href="{{ route('a2.edit', $r->id_reg) }}" title="Edit"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-amber-600 hover:bg-amber-700 text-white rounded transition-colors">
                                            <i class="bi bi-pencil text-xs"></i>
                                        </a>

                                        <a href="{{ route('a2.print', $r->id_reg) }}" target="_blank" title="Cetak"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-green-700 hover:bg-green-800 text-white rounded transition-colors">
                                            <i class="bi bi-printer text-xs"></i>
                                        </a>

                                        <form action="{{ route('a2.destroy', $r->id_reg) }}" method="POST"
                                            title="Hapus" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-7 h-7 bg-red-600 hover:bg-red-700 text-white rounded transition-colors">
                                                <i class="bi bi-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-400">
                                        <i class="bi bi-inbox text-3xl"></i>
                                        <p class="text-sm">Data belum tersedia</p>
                                        @if (request()->hasAny(['q', 'tgl_dari', 'tgl_sampai', 'f_no_reg', 'f_subkeg', 'f_rekbel', 'f_keperluan', 'f_nominal']))
                                            <a href="{{ route('a2.index') }}"
                                                class="text-xs text-blue-500 hover:underline">Hapus semua filter</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- Footer total --}}
                    @if ($registers->count())
                        <tfoot>
                            <tr class="bg-slate-100 font-semibold text-slate-700">
                                <td colspan="5" class="px-3 py-2 border border-slate-200 text-right text-xs">
                                    Total Nominal (halaman ini):
                                </td>
                                <td class="px-3 py-2 border border-slate-200 text-right text-xs whitespace-nowrap">
                                    Rp {{ number_format($registers->sum('nom_bruto'), 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-2 border border-slate-200"></td>
                            </tr>
                        </tfoot>
                    @endif

                </table>
            </div>
        </div>

        {{-- ── PAGINATION ── --}}
        <div class="mt-4 flex items-center justify-between">
            <p class="text-xs text-slate-400">
                Menampilkan {{ $registers->firstItem() ?? 0 }}–{{ $registers->lastItem() ?? 0 }}
                dari {{ $registers->total() }} data
            </p>
            <div class="text-sm">
                {{ $registers->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        {{-- Enter di kolom search langsung submit form --}}
        document.querySelectorAll('#col-search-form input').forEach(input => {
            input.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('col-search-form').submit();
                }
            });
        });
    </script>
@endpush
