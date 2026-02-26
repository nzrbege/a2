<div class="grid grid-cols-1 gap-4">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Nama Penerima
        </label>
        <input type="text" name="penerima"
               value="{{ old('penerima', $penerima->penerima ?? '') }}"
               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
        @error('penerima')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            NPWP
        </label>
        <input type="text" name="npwp"
               value="{{ old('npwp', $penerima->npwp ?? '') }}"
               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Bank
        </label>
        <input type="text" name="bankpenerima"
               value="{{ old('bankpenerima', $penerima->bankpenerima ?? '') }}"
               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            No Rekening
        </label>
        <input type="text" name="norek_penerima"
               value="{{ old('norek_penerima', $penerima->norek_penerima ?? '') }}"
               class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Alamat
        </label>
        <textarea name="alamat"
                  rows="3"
                  class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">{{ old('alamat', $penerima->alamat ?? '') }}</textarea>
    </div>

</div>