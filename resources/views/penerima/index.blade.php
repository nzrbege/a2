@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-800">
            Data Penerima
        </h1>

        <a href="{{ route('penerima.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            + Tambah
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">NPWP</th>
                    <th class="px-4 py-3 text-left">Bank</th>
                    <th class="px-4 py-3 text-left">No Rekening</th>
                    <th class="px-4 py-3 text-left">Alamat</th>
                    <th class="px-4 py-3 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($penerimas as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $item->penerima }}
                    </td>
                    <td class="px-4 py-3">{{ $item->npwp }}</td>
                    <td class="px-4 py-3">{{ $item->bankpenerima }}</td>
                    <td class="px-4 py-3">{{ $item->norek_penerima }}</td>
                    <td class="px-4 py-3">{{ $item->alamat }}</td>
                    <td class="px-4 py-3 text-center space-x-2">

                        <a href="{{ route('penerima.edit', $item->id) }}"
                           class="px-3 py-1 text-xs bg-emerald-600 text-white rounded-md hover:bg-emerald-600">
                            Edit
                        </a>

                        <form action="{{ route('penerima.destroy', $item->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')"
                                    class="px-3 py-1 text-xs bg-red-600 text-white rounded-md hover:bg-red-700">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        Belum ada data penerima
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $penerimas->links() }}
    </div>

</div>
@endsection