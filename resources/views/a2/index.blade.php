@extends('layouts.app')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 py-6 space-y-5">

    {{-- HEADER --}}
    <div class="flex items-center justify-between rounded-2xl px-6 py-4 border shadow-sm
                bg-white border-slate-200
                dark:bg-slate-800 dark:border-slate-700/60">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-blue-600 dark:bg-blue-500 flex items-center justify-center shadow-lg shadow-blue-200 dark:shadow-blue-900/30 shrink-0">
                <i class="bi bi-journal-text text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-base font-extrabold tracking-tight leading-none text-slate-900 dark:text-white">Daftar Register A2</h1>
                <p class="text-xs mt-1 text-slate-400 dark:text-slate-500">Bukti Pengeluaran Bidang Informatika &mdash; {{ date('Y') }}</p>
            </div>
        </div>
        <a href="{{ route('a2.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 text-white text-xs font-bold rounded-xl shadow transition-all duration-200 hover:-translate-y-px
                  bg-blue-600 hover:bg-blue-700 shadow-blue-200 dark:shadow-blue-900/30">
            <i class="bi bi-plus-lg"></i> Tambah Register
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)"
             x-show="show" x-transition
             class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-sm font-medium border
                    bg-emerald-50 border-emerald-200 text-emerald-700
                    dark:bg-emerald-500/10 dark:border-emerald-500/30 dark:text-emerald-400">
            <div class="flex items-center gap-2">
                <i class="bi bi-check-circle-fill text-emerald-500 dark:text-emerald-400"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-xl leading-none text-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-300">&times;</button>
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)"
             x-show="show" x-transition
             class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-sm font-medium border
                    bg-red-50 border-red-200 text-red-700
                    dark:bg-red-500/10 dark:border-red-500/30 dark:text-red-400">
            <div class="flex items-center gap-2">
                <i class="bi bi-exclamation-circle-fill text-red-500 dark:text-red-400"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-xl leading-none text-red-400 hover:text-red-600 dark:hover:text-red-300">&times;</button>
        </div>
    @endif

    {{-- FILTER BAR --}}
    <form method="GET" action="{{ route('a2.index') }}"
          class="rounded-2xl px-5 py-4 flex flex-wrap gap-3 items-end border shadow-sm
                 bg-white border-slate-200
                 dark:bg-slate-800 dark:border-slate-700/60">

        <input type="hidden" name="sort"  value="{{ request('sort') }}">
        <input type="hidden" name="order" value="{{ request('order') }}">

        <div class="flex flex-col gap-1.5">
            <label class="text-[10px] font-bold uppercase tracking-widest flex items-center gap-1.5 text-slate-400 dark:text-slate-500">
                <i class="bi bi-search text-blue-400"></i> Cari Global
            </label>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="No / Rekening / Keperluan…"
                   class="w-56 border rounded-xl px-3 py-2 text-xs transition
                          border-slate-200 bg-slate-50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white
                          dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 dark:placeholder-slate-500 dark:focus:bg-slate-600">
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[10px] font-bold uppercase tracking-widest flex items-center gap-1.5 text-slate-400 dark:text-slate-500">
                <i class="bi bi-calendar3 text-blue-400"></i> Tanggal Dari
            </label>
            <input type="date" name="tgl_dari" value="{{ request('tgl_dari') }}"
                   class="border rounded-xl px-3 py-2 text-xs transition
                          border-slate-200 bg-slate-50 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white
                          dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 dark:focus:bg-slate-600">
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[10px] font-bold uppercase tracking-widest flex items-center gap-1.5 text-slate-400 dark:text-slate-500">
                <i class="bi bi-calendar3-range text-blue-400"></i> Tanggal Sampai
            </label>
            <input type="date" name="tgl_sampai" value="{{ request('tgl_sampai') }}"
                   class="border rounded-xl px-3 py-2 text-xs transition
                          border-slate-200 bg-slate-50 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white
                          dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 dark:focus:bg-slate-600">
        </div>

        <div class="flex gap-2 items-end">
            <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2 text-white text-xs font-bold rounded-xl transition-all duration-150
                           bg-blue-600 hover:bg-blue-700">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
            <a href="{{ route('a2.index') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold rounded-xl border transition-all duration-150
                      bg-slate-100 hover:bg-slate-200 text-slate-600 border-slate-200
                      dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-slate-300 dark:border-slate-600">
                <i class="bi bi-x-lg"></i> Reset
            </a>
        </div>

        <div class="ml-auto self-end inline-flex items-center gap-2 rounded-xl px-4 py-2 border
                    bg-blue-50 border-blue-100
                    dark:bg-blue-500/10 dark:border-blue-500/20">
            <i class="bi bi-database-fill text-blue-400 text-xs"></i>
            <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ $registers->total() }}</span>
            <span class="text-xs text-slate-400 dark:text-slate-500">data ditemukan</span>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="rounded-2xl border overflow-hidden shadow-sm
                bg-white border-slate-200
                dark:bg-slate-800 dark:border-slate-700/60">
        <div class="overflow-x-auto">
            <table class="w-full text-xs border-collapse">
                <thead>
                    {{-- Header row --}}
                    <tr class="text-left bg-slate-900 dark:bg-slate-950">
                        <th class="px-4 py-3.5 text-center text-slate-400 font-semibold text-[11px] border-r border-white/5 w-10">#</th>

                        @php
                            $cols = [
                                'gen_no_reg'  => ['label' => 'No Register',     'icon' => 'bi-hash'],
                                'urai_subkeg' => ['label' => 'Sub Kegiatan',     'icon' => 'bi-diagram-3'],
                                'urai_rekbel' => ['label' => 'Rekening Belanja', 'icon' => 'bi-card-list'],
                                'keperluan'   => ['label' => 'Keperluan',        'icon' => 'bi-file-text'],
                                'nom_bruto'   => ['label' => 'Nominal',          'icon' => 'bi-currency-exchange'],
                            ];
                            $currentSort  = request('sort', 'gen_no_reg');
                            $currentOrder = request('order', 'asc');
                        @endphp

                        @foreach ($cols as $field => $meta)
                            @php
                                $nextOrder = $currentSort === $field && $currentOrder === 'asc' ? 'desc' : 'asc';
                                $isActive  = $currentSort === $field;
                                $sortIcon  = $isActive ? ($currentOrder === 'asc' ? 'bi-sort-up' : 'bi-sort-down') : 'bi-arrow-down-up';
                                $alignTh   = $field === 'nom_bruto' ? 'text-right' : 'text-left';
                            @endphp
                            <th class="px-4 py-3.5 {{ $alignTh }} border-r border-white/5 whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => $field, 'order' => $nextOrder]) }}"
                                   class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider transition-colors
                                          {{ $isActive ? 'text-amber-400' : 'text-slate-400 hover:text-amber-300' }}">
                                    <i class="bi {{ $meta['icon'] }} opacity-70 text-[10px]"></i>
                                    {{ $meta['label'] }}
                                    <i class="bi {{ $sortIcon }} text-[10px] {{ $isActive ? 'opacity-100' : 'opacity-40' }}"></i>
                                </a>
                            </th>
                        @endforeach

                        <th class="px-4 py-3.5 text-center w-36">
                            <span class="inline-flex items-center justify-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                <i class="bi bi-sliders2 opacity-70 text-[10px]"></i> Aksi
                            </span>
                        </th>
                    </tr>

                    {{-- Column search row --}}
                    <form method="GET" action="{{ route('a2.index') }}" id="col-search-form">
                        <input type="hidden" name="sort"       value="{{ request('sort') }}">
                        <input type="hidden" name="order"      value="{{ request('order') }}">
                        <input type="hidden" name="tgl_dari"   value="{{ request('tgl_dari') }}">
                        <input type="hidden" name="tgl_sampai" value="{{ request('tgl_sampai') }}">

                        <tr class="bg-slate-800 dark:bg-slate-900">
                            <th class="px-2 py-2 border-r border-white/5"></th>
                            @foreach(['f_no_reg' => 'No register…', 'f_subkeg' => 'Sub kegiatan…', 'f_rekbel' => 'Rekening…', 'f_keperluan' => 'Keperluan…'] as $fname => $ph)
                            <th class="px-2 py-2 border-r border-white/5">
                                <input type="text" name="{{ $fname }}" value="{{ request($fname) }}"
                                       placeholder="{{ $ph }}"
                                       class="col-search-input w-full text-[11px] rounded-lg px-2.5 py-1.5 transition
                                              bg-slate-700 text-white placeholder-slate-500 border border-slate-600
                                              focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50">
                            </th>
                            @endforeach
                            <th class="px-2 py-2 border-r border-white/5">
                                <input type="text" name="f_nominal" value="{{ request('f_nominal') }}"
                                       placeholder="Nominal…"
                                       class="col-search-input w-full text-[11px] rounded-lg px-2.5 py-1.5 text-right transition
                                              bg-slate-700 text-white placeholder-slate-500 border border-slate-600
                                              focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400/50">
                            </th>
                            <th class="px-2 py-2">
                                <button type="submit"
                                        class="w-full py-1.5 text-[11px] font-bold rounded-lg transition-all duration-150 flex items-center justify-center
                                               bg-amber-400 hover:bg-amber-300 text-slate-900">
                                    <i class="bi bi-search"></i>
                                </button>
                            </th>
                        </tr>
                    </form>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse ($registers as $i => $r)
                        <tr class="transition-colors duration-100 group
                                   {{ $i % 2 === 0 ? 'bg-white dark:bg-slate-800' : 'bg-slate-50/60 dark:bg-slate-700/20' }}
                                   hover:bg-blue-50/50 dark:hover:bg-blue-500/5">

                            <td class="px-4 py-3 text-center border-r border-slate-100 dark:border-slate-700/60">
                                <span class="text-slate-400 font-semibold tabular-nums text-[11px]">{{ $registers->firstItem() + $i }}</span>
                            </td>

                            <td class="px-4 py-3 border-r border-slate-100 dark:border-slate-700/60">
                                <span class="inline-flex items-center gap-1 font-bold text-[11px] rounded-md px-2 py-1 whitespace-nowrap font-mono transition-colors
                                             bg-blue-50 text-blue-700 group-hover:bg-blue-100
                                             dark:bg-blue-500/15 dark:text-blue-300 dark:group-hover:bg-blue-500/25">
                                    <i class="bi bi-hash text-blue-400 text-[10px]"></i>{{ $r->gen_no_reg }}
                                </span>
                            </td>

                            <td class="px-4 py-3 border-r border-slate-100 dark:border-slate-700/60 max-w-xs text-slate-600 dark:text-slate-300">
                                <span class="line-clamp-2 leading-relaxed" title="{{ $r->urai_subkeg }}">{{ $r->urai_subkeg }}</span>
                            </td>

                            <td class="px-4 py-3 border-r border-slate-100 dark:border-slate-700/60 text-slate-600 dark:text-slate-300">
                                <span class="line-clamp-2 leading-relaxed" title="{{ $r->urai_rekbel }}">{{ $r->urai_rekbel }}</span>
                            </td>

                            <td class="px-4 py-3 border-r border-slate-100 dark:border-slate-700/60 max-w-xs text-slate-600 dark:text-slate-300">
                                <span class="line-clamp-2 leading-relaxed" title="{{ $r->keperluan }}">{{ $r->keperluan }}</span>
                            </td>

                            <td class="px-4 py-3 border-r border-slate-100 dark:border-slate-700/60 text-right whitespace-nowrap">
                                <span class="font-bold tabular-nums font-mono text-slate-800 dark:text-slate-100">
                                    Rp {{ number_format($r->nom_bruto, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center items-center gap-1.5">
                                    <a href="{{ route('a2.show', $r->id_reg) }}" title="Lihat Detail"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-150 hover:-translate-y-px
                                              bg-violet-50 text-violet-600 hover:bg-violet-600 hover:text-white
                                              dark:bg-violet-500/15 dark:text-violet-400 dark:hover:bg-violet-500 dark:hover:text-white">
                                        <i class="bi bi-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('a2.edit', $r->id_reg) }}" title="Edit"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-150 hover:-translate-y-px
                                              bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white
                                              dark:bg-amber-500/15 dark:text-amber-400 dark:hover:bg-amber-500 dark:hover:text-white">
                                        <i class="bi bi-pencil text-xs"></i>
                                    </a>
                                    <a href="{{ route('a2.print', $r->id_reg) }}" target="_blank" title="Cetak"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-150 hover:-translate-y-px
                                              bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white
                                              dark:bg-emerald-500/15 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white">
                                        <i class="bi bi-printer text-xs"></i>
                                    </a>
                                    <form action="{{ route('a2.destroy', $r->id_reg) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display:contents">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-150 hover:-translate-y-px
                                                       bg-red-50 text-red-500 hover:bg-red-500 hover:text-white
                                                       dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500 dark:hover:text-white">
                                            <i class="bi bi-trash3 text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-20 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-2xl border-2 border-dashed flex items-center justify-center
                                                bg-slate-100 border-slate-200
                                                dark:bg-slate-700 dark:border-slate-600">
                                        <i class="bi bi-inbox text-3xl text-slate-300 dark:text-slate-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400">Data tidak ditemukan</p>
                                        <p class="text-xs mt-1 text-slate-400 dark:text-slate-500">Coba ubah filter pencarian</p>
                                    </div>
                                    @if (request()->hasAny(['q','tgl_dari','tgl_sampai','f_no_reg','f_subkeg','f_rekbel','f_keperluan','f_nominal']))
                                        <a href="{{ route('a2.index') }}"
                                           class="text-xs hover:underline inline-flex items-center gap-1 mt-1 text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i class="bi bi-x-circle"></i> Hapus semua filter
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                @if ($registers->count())
                    <tfoot>
                        <tr class="border-t border-slate-200 dark:border-slate-700
                                   bg-slate-50 dark:bg-slate-700/30">
                            <td colspan="5" class="px-4 py-3 text-right">
                                <span class="inline-flex items-center justify-end gap-1.5 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    <i class="bi bi-calculator text-blue-400"></i>
                                    Total Nominal (halaman ini):
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right text-xs font-extrabold tabular-nums font-mono whitespace-nowrap
                                       text-slate-800 dark:text-slate-100">
                                Rp {{ number_format($registers->sum('nom_bruto'), 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="flex items-center justify-between pt-1">
        <p class="text-xs flex items-center gap-1.5 text-slate-400 dark:text-slate-500">
            <i class="bi bi-list-ol text-slate-300 dark:text-slate-600"></i>
            Menampilkan
            <span class="font-bold text-slate-600 dark:text-slate-300">{{ $registers->firstItem() ?? 0 }}–{{ $registers->lastItem() ?? 0 }}</span>
            dari
            <span class="font-bold text-slate-600 dark:text-slate-300">{{ $registers->total() }}</span>
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
        input.addEventListener('blur', e => {
            const goingTo = e.relatedTarget;
            const stayingInForm = goingTo && colSearchForm.contains(goingTo);
            if (!stayingInForm) colSearchForm.submit();
        });

        input.addEventListener('keydown', e => {
            if (e.key === 'Enter') { e.preventDefault(); colSearchForm.submit(); }
            if (e.key === 'Escape') { input.value = ''; colSearchForm.submit(); }
        });
    });
</script>
@endpush
