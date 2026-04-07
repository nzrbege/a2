@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4 space-y-4">

        {{-- ── HEADER ── --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-bold text-slate-800 tracking-tight flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-600 text-white">
                        <i class="bi bi-journal-text text-sm"></i>
                    </span>
                    Daftar Register A2
                </h1>
                <p class="text-xs text-slate-400 mt-0.5 ml-10">Bukti Pengeluaran Bidang Informatika {{ date('Y') }}</p>
            </div>
            <a href="{{ route('a2.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-all duration-150">
                <i class="bi bi-plus-lg"></i> Tambah Register
            </a>
        </div>

        {{-- ── ALERT SUCCESS ── --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="flex items-center justify-between gap-3 px-4 py-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-emerald-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 text-lg leading-none">&times;</button>
            </div>
        @endif

        {{-- ── ALERT ERROR ── --}}
        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="flex items-center justify-between gap-3 px-4 py-2.5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                <div class="flex items-center gap-2">
                    <i class="bi bi-exclamation-circle-fill text-red-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-red-400 hover:text-red-600 text-lg leading-none">&times;</button>
            </div>
        @endif

        {{-- ── FILTER BAR ── --}}
        <form method="GET" action="{{ route('a2.index') }}"
            class="bg-white border border-slate-200 rounded-xl px-5 py-4 flex flex-wrap gap-3 items-end">

            <input type="hidden" name="sort" value="{{ request('sort') }}">
            <input type="hidden" name="order" value="{{ request('order') }}">

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                    <i class="bi bi-search text-blue-400"></i> Cari Global
                </label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="No / Rekening / Keperluan"
                    class="border border-slate-300 rounded-lg px-3 py-1.5 text-xs w-56 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                    <i class="bi bi-calendar-event text-blue-400"></i> Tanggal Dari
                </label>
                <input type="date" name="tgl_dari" value="{{ request('tgl_dari') }}"
                    class="border border-slate-300 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                    <i class="bi bi-calendar-check text-blue-400"></i> Tanggal Sampai
                </label>
                <input type="date" name="tgl_sampai" value="{{ request('tgl_sampai') }}"
                    class="border border-slate-300 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-all duration-150 flex items-center gap-1.5">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                <a href="{{ route('a2.index') }}"
                    class="px-4 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-lg transition-all duration-150 flex items-center gap-1.5">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            </div>

            <div class="ml-auto flex items-center gap-1.5 self-center bg-blue-50 border border-blue-100 rounded-lg px-3 py-1.5">
                <i class="bi bi-database text-blue-400 text-xs"></i>
                <span class="text-xs font-semibold text-blue-600">{{ $registers->total() }}</span>
                <span class="text-xs text-blue-400">data ditemukan</span>
            </div>
        </form>

        {{-- ── TABEL ── --}}
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs border-collapse">
                    <thead>

                        {{-- Baris 1: nama kolom + sort --}}
                        <tr class="text-left" style="background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 60%, #2563eb 100%);">
                            <th class="px-3 py-3 border-r border-blue-700/50 w-10 text-center text-blue-200 font-medium">#</th>

                            @php
                                $cols = [
                                    'gen_no_reg'  => ['label' => 'No Register',       'icon' => 'bi-hash'],
                                    'urai_subkeg' => ['label' => 'Sub Kegiatan',       'icon' => 'bi-diagram-3'],
                                    'urai_rekbel' => ['label' => 'Rekening Belanja',   'icon' => 'bi-card-list'],
                                    'keperluan'   => ['label' => 'Keperluan',          'icon' => 'bi-file-text'],
                                    'nom_bruto'   => ['label' => 'Nominal',            'icon' => 'bi-currency-dollar'],
                                ];
                                $currentSort  = request('sort', 'gen_no_reg');
                                $currentOrder = request('order', 'asc');
                            @endphp

                            @foreach ($cols as $field => $meta)
                                @php
                                    $nextOrder = $currentSort === $field && $currentOrder === 'asc' ? 'desc' : 'asc';
                                    $isActive  = $currentSort === $field;
                                    $icon      = $isActive ? ($currentOrder === 'asc' ? 'bi-sort-up' : 'bi-sort-down') : 'bi-arrow-down-up';
                                    $align     = $field === 'nom_bruto' ? 'text-right' : 'text-left';
                                @endphp
                                <th class="px-3 py-3 border-r border-blue-700/50 {{ $align }} whitespace-nowrap">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => $field, 'order' => $nextOrder]) }}"
                                        class="inline-flex items-center gap-1.5 font-semibold transition-colors
                                            {{ $isActive ? 'text-yellow-300' : 'text-white/90 hover:text-yellow-200' }}">
                                        <i class="bi {{ $meta['icon'] }} text-xs opacity-70"></i>
                                        {{ $meta['label'] }}
                                        <i class="bi {{ $icon }} text-xs {{ $isActive ? 'opacity-100' : 'opacity-50' }}"></i>
                                    </a>
                                </th>
                            @endforeach

                            <th class="px-3 py-3 text-center text-white/90 font-semibold w-32">
                                <span class="inline-flex items-center gap-1"><i class="bi bi-gear text-xs opacity-70"></i> Aksi</span>
                            </th>
                        </tr>

                        {{-- Baris 2: search per kolom --}}
                        <form method="GET" action="{{ route('a2.index') }}" id="col-search-form">
                            <input type="hidden" name="sort"      value="{{ request('sort') }}">
                            <input type="hidden" name="order"     value="{{ request('order') }}">
                            <input type="hidden" name="tgl_dari"  value="{{ request('tgl_dari') }}">
                            <input type="hidden" name="tgl_sampai"value="{{ request('tgl_sampai') }}">
                            <tr style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);">
                                <th class="px-1.5 py-1.5 border-r border-blue-800/60"></th>
                                <th class="px-1.5 py-1.5 border-r border-blue-800/60">
                                    <input type="text" name="f_no_reg" value="{{ request('f_no_reg') }}"
                                        placeholder="🔍 No register..."
                                        class="col-search-input w-full text-xs rounded-lg px-2 py-1.5 bg-blue-950/60 text-white placeholder-blue-300/60 border border-blue-700/50 focus:outline-none focus:ring-2 focus:ring-yellow-400/70 focus:border-yellow-400/50 transition">
                                </th>
                                <th class="px-1.5 py-1.5 border-r border-blue-800/60">
                                    <input type="text" name="f_subkeg" value="{{ request('f_subkeg') }}"
                                        placeholder="🔍 Sub kegiatan..."
                                        class="col-search-input w-full text-xs rounded-lg px-2 py-1.5 bg-blue-950/60 text-white placeholder-blue-300/60 border border-blue-700/50 focus:outline-none focus:ring-2 focus:ring-yellow-400/70 focus:border-yellow-400/50 transition">
                                </th>
                                <th class="px-1.5 py-1.5 border-r border-blue-800/60">
                                    <input type="text" name="f_rekbel" value="{{ request('f_rekbel') }}"
                                        placeholder="🔍 Rekening..."
                                        class="col-search-input w-full text-xs rounded-lg px-2 py-1.5 bg-blue-950/60 text-white placeholder-blue-300/60 border border-blue-700/50 focus:outline-none focus:ring-2 focus:ring-yellow-400/70 focus:border-yellow-400/50 transition">
                                </th>
                                <th class="px-1.5 py-1.5 border-r border-blue-800/60">
                                    <input type="text" name="f_keperluan" value="{{ request('f_keperluan') }}"
                                        placeholder="🔍 Keperluan..."
                                        class="col-search-input w-full text-xs rounded-lg px-2 py-1.5 bg-blue-950/60 text-white placeholder-blue-300/60 border border-blue-700/50 focus:outline-none focus:ring-2 focus:ring-yellow-400/70 focus:border-yellow-400/50 transition">
                                </th>
                                <th class="px-1.5 py-1.5 border-r border-blue-800/60">
                                    <input type="text" name="f_nominal" value="{{ request('f_nominal') }}"
                                        placeholder="🔍 Nominal..."
                                        class="col-search-input w-full text-xs rounded-lg px-2 py-1.5 bg-blue-950/60 text-white placeholder-blue-300/60 border border-blue-700/50 focus:outline-none focus:ring-2 focus:ring-yellow-400/70 focus:border-yellow-400/50 transition text-right">
                                </th>
                                <th class="px-1.5 py-1.5 text-center">
                                    <button type="submit"
                                        class="w-full px-2 py-1.5 bg-yellow-400 hover:bg-yellow-300 text-blue-900 text-xs font-bold rounded-lg transition-all duration-150 shadow-sm flex items-center justify-center gap-1">
                                        <i class="bi bi-search text-xs"></i>
                                    </button>
                                </th>
                            </tr>
                        </form>

                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($registers as $i => $r)
                            <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-slate-50/70' }} hover:bg-blue-50/60 transition-colors duration-100 group">

                                <td class="px-3 py-2.5 text-center border-r border-slate-100">
                                    <span class="text-slate-400 font-medium tabular-nums">{{ $registers->firstItem() + $i }}</span>
                                </td>

                                <td class="px-3 py-2.5 border-r border-slate-100">
                                    <span class="inline-flex items-center gap-1 font-semibold text-blue-700 bg-blue-50 group-hover:bg-blue-100 rounded-md px-2 py-0.5 whitespace-nowrap transition-colors">
                                        <i class="bi bi-hash text-blue-400 text-xs"></i>{{ $r->gen_no_reg }}
                                    </span>
                                </td>

                                <td class="px-3 py-2.5 border-r border-slate-100 text-slate-600 max-w-xs">
                                    <span class="line-clamp-2 leading-relaxed" title="{{ $r->urai_subkeg }}">{{ $r->urai_subkeg }}</span>
                                </td>

                                <td class="px-3 py-2.5 border-r border-slate-100 text-slate-600">
                                    <span class="line-clamp-2 leading-relaxed" title="{{ $r->urai_rekbel }}">{{ $r->urai_rekbel }}</span>
                                </td>

                                <td class="px-3 py-2.5 border-r border-slate-100 text-slate-600 max-w-xs">
                                    <span class="line-clamp-2 leading-relaxed" title="{{ $r->keperluan }}">{{ $r->keperluan }}</span>
                                </td>

                                <td class="px-3 py-2.5 border-r border-slate-100 text-right whitespace-nowrap">
                                    <span class="font-semibold text-slate-800 tabular-nums">
                                        Rp {{ number_format($r->nom_bruto, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="px-3 py-2.5">
                                    <div class="flex justify-center items-center gap-1">
                                        <a href="{{ route('a2.show', $r->id_reg) }}" title="Lihat Detail"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition-all duration-150 hover:scale-105">
                                            <i class="bi bi-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('a2.edit', $r->id_reg) }}" title="Edit"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-all duration-150 hover:scale-105">
                                            <i class="bi bi-pencil text-xs"></i>
                                        </a>
                                        <a href="{{ route('a2.print', $r->id_reg) }}" target="_blank" title="Cetak"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-all duration-150 hover:scale-105">
                                            <i class="bi bi-printer text-xs"></i>
                                        </a>
                                        <form action="{{ route('a2.destroy', $r->id_reg) }}" method="POST"
                                            title="Hapus" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-150 hover:scale-105">
                                                <i class="bi bi-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                            <i class="bi bi-inbox text-3xl text-slate-300"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-500">Data tidak ditemukan</p>
                                            <p class="text-xs mt-0.5">Coba ubah filter pencarian</p>
                                        </div>
                                        @if (request()->hasAny(['q', 'tgl_dari', 'tgl_sampai', 'f_no_reg', 'f_subkeg', 'f_rekbel', 'f_keperluan', 'f_nominal']))
                                            <a href="{{ route('a2.index') }}"
                                                class="text-xs text-blue-500 hover:text-blue-700 hover:underline flex items-center gap-1">
                                                <i class="bi bi-x-circle"></i> Hapus semua filter
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- Footer total --}}
                    @if ($registers->count())
                        <tfoot>
                            <tr class="bg-gradient-to-r from-slate-100 to-blue-50 font-semibold text-slate-700">
                                <td colspan="5" class="px-3 py-2.5 border-t border-slate-200 text-right text-xs text-slate-500">
                                    <span class="flex items-center justify-end gap-1.5">
                                        <i class="bi bi-calculator text-blue-400"></i>
                                        Total Nominal (halaman ini):
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 border-t border-slate-200 text-right text-xs font-bold text-slate-800 whitespace-nowrap tabular-nums">
                                    Rp {{ number_format($registers->sum('nom_bruto'), 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-2.5 border-t border-slate-200"></td>
                            </tr>
                        </tfoot>
                    @endif

                </table>
            </div>
        </div>

        {{-- ── PAGINATION ── --}}
        <div class="flex items-center justify-between pt-1">
            <p class="text-xs text-slate-400 flex items-center gap-1.5">
                <i class="bi bi-list-ol text-slate-300"></i>
                Menampilkan
                <span class="font-semibold text-slate-600">{{ $registers->firstItem() ?? 0 }}–{{ $registers->lastItem() ?? 0 }}</span>
                dari
                <span class="font-semibold text-slate-600">{{ $registers->total() }}</span>
                data
            </p>
            <div class="text-sm">
                {{ $registers->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const colSearchForm = document.getElementById('col-search-form');
        const colSearchInputs = colSearchForm.querySelectorAll('input.col-search-input');

        colSearchInputs.forEach(input => {
            // Auto-search saat blur — hanya jika fokus pindah ke LUAR form
            // (Tab ke input lain dalam form tidak trigger submit)
            input.addEventListener('blur', e => {
                const goingTo = e.relatedTarget;
                const stayingInForm = goingTo && colSearchForm.contains(goingTo);
                if (!stayingInForm) {
                    colSearchForm.submit();
                }
            });

            input.addEventListener('keydown', e => {
                // Enter: langsung submit
                if (e.key === 'Enter') {
                    e.preventDefault();
                    colSearchForm.submit();
                }
                // Escape: kosongkan field lalu submit
                if (e.key === 'Escape') {
                    input.value = '';
                    colSearchForm.submit();
                }
            });
        });
    </script>
@endpush
