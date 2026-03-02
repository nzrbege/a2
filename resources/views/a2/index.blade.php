@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4">
    <h1 class="text-xl font-semibold mb-4">Daftar Register A2</h1>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="mb-3 p-3 bg-green-100 text-green-700 rounded flex justify-between items-center">

        <span>{{ session('success') }}</span>

        <button @click="show = false" class="text-green-700 font-bold">
            ✕
        </button>
    </div>
    @endif

    {{-- ALERT ERROR --}}
    @if(session('error'))
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition
        class="mb-3 p-3 bg-red-100 text-red-700 rounded flex justify-between items-center">

        <span>{{ session('error') }}</span>

        <button @click="show = false" class="text-red-700 font-bold">
            ✕
        </button>
    </div>
    @endif

    <form method="GET" action="{{ route('a2.index') }}"
      class="mb-4 bg-white p-4 rounded shadow flex flex-wrap gap-3 items-end">

    <div>
        <label class="block text-xs text-gray-600 mb-1">Cari</label>
        <input type="text"
               name="q"
               value="{{ request('q') }}"
               placeholder="No / Rekening / Keperluan"
               class="border rounded px-3 py-2 text-sm w-64">
    </div>

    <div>
        <label class="block text-xs text-gray-600 mb-1">Tanggal Dari</label>
        <input type="date"
               name="tgl_dari"
               value="{{ request('tgl_dari') }}"
               class="border rounded px-3 py-2 text-sm">
    </div>

    <div>
        <label class="block text-xs text-gray-600 mb-1">Tanggal Sampai</label>
        <input type="date"
               name="tgl_sampai"
               value="{{ request('tgl_sampai') }}"
               class="border rounded px-3 py-2 text-sm">
    </div>

    <div class="flex gap-2">
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded text-sm">
            Filter
        </button>

        <a href="{{ route('a2.index') }}"
           class="px-4 py-2 bg-gray-300 rounded text-sm">
            Reset
        </a>
    </div>

</form>


    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">No Register</th>
                    <th class="p-2 border">Sub Kegiatan</th>
                    <th class="p-2 border">Rekening Belanja</th>
                    <th class="p-2 border">Keperluan</th>
                    <th class="p-2 border text-right">Nominal</th>
                    <th class="p-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registers as $i => $r)
                <tr class="hover:bg-gray-50">
                    <td class="p-2 border">
                        {{ $registers->firstItem() + $i }}
                    </td>
                    <td class="p-2 border">
                        {{ $r->gen_no_reg }}
                    </td>
                    {{-- <td class="p-2 border">
                        {{ \Carbon\Carbon::parse($r->created_at)->translatedFormat('d F Y') }}
                    </td> --}}
                    <td class="p-2 border">
                        {{ $r->urai_subkeg }}
                    </td>
                    <td class="p-2 border">
                        {{ $r->urai_rekbel }}
                    </td>
                    <td class="p-2 border">
                        {{ $r->keperluan }}
                    </td>
                    <td class="p-2 border text-right">
                        Rp {{ number_format($r->nom_bruto, 2, ',', '.') }}
                    </td>
                    <td class="p-2 border text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('a2.show', $r->id_reg) }}"
                               class="px-2 py-1 bg-indigo-700 text-white rounded text-xs">
                                View
                            </a>

                            <a href="{{ route('a2.edit', $r->id_reg) }}"
                               class="px-2 py-1 bg-green-700 text-white rounded text-xs">
                                Edit
                            </a>

                            <form action="{{ route('a2.destroy', $r->id_reg) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-2 py-1 bg-red-600 text-white rounded text-xs">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">
                        Data belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $registers->links() }}
    </div>
</div>
@endsection
