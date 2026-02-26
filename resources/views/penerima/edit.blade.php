@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">

    <h1 class="text-xl font-bold mb-6 text-gray-800">
        Edit Penerima
    </h1>

    <div class="bg-white p-6 rounded-xl shadow">
        <form action="{{ route('penerima.update', $penerima->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('penerima.form')

            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('penerima.index') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                    Batal
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Update
                </button>
            </div>
        </form>
    </div>

</div>
@endsection