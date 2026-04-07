<div class="grid grid-cols-1 gap-5">

    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1.5">
            Nama Penerima
        </label>
        <input type="text" name="penerima"
               value="{{ old('penerima', $penerima->penerima ?? '') }}"
               placeholder="Masukkan nama penerima"
               class="w-full border-2 border-gray-200 bg-gray-50 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
        @error('penerima')
            <p class="text-red-500 text-xs font-medium mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1.5">
            NPWP
        </label>
        <input type="text" name="npwp"
               value="{{ old('npwp', $penerima->npwp ?? '') }}"
               placeholder="Masukkan NPWP"
               class="w-full border-2 border-gray-200 bg-gray-50 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1.5">
            Bank
        </label>
        <input type="text" name="bankpenerima"
               value="{{ old('bankpenerima', $penerima->bankpenerima ?? '') }}"
               placeholder="Masukkan nama bank"
               class="w-full border-2 border-gray-200 bg-gray-50 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1.5">
            No Rekening
        </label>
        <input type="text" name="norek_penerima"
               value="{{ old('norek_penerima', $penerima->norek_penerima ?? '') }}"
               placeholder="Masukkan nomor rekening"
               class="w-full border-2 border-gray-200 bg-gray-50 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1.5">
            Alamat
        </label>
        <textarea name="alamat"
                  rows="3"
                  placeholder="Masukkan alamat"
                  class="w-full border-2 border-gray-200 bg-gray-50 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors resize-none">{{ old('alamat', $penerima->alamat ?? '') }}</textarea>
    </div>

</div>
