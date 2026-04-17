<div class="grid grid-cols-1 gap-6">

    {{-- Nama Penerima --}}
    <div class="group">
        <label class="flex items-center gap-2 text-sm font-semibold mb-2 text-slate-500 dark:text-slate-400 group-focus-within:text-blue-500 dark:group-focus-within:text-blue-400 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Nama Penerima
        </label>
        <input type="text" name="penerima"
               value="{{ old('penerima', $penerima->penerima ?? '') }}"
               placeholder="Masukkan nama lengkap penerima"
               class="w-full border-2 border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-300 dark:placeholder:text-slate-500 focus:outline-none focus:border-blue-400 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200">
        @error('penerima')
            <p class="text-red-500 text-xs font-medium mt-1.5 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- NPWP --}}
    <div class="group">
        <label class="flex items-center gap-2 text-sm font-semibold mb-2 text-slate-500 dark:text-slate-400 group-focus-within:text-blue-500 dark:group-focus-within:text-blue-400 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
            </svg>
            NPWP
        </label>
        <input type="text" name="npwp"
               value="{{ old('npwp', $penerima->npwp ?? '') }}"
               placeholder="Masukkan nomor NPWP"
               class="w-full border-2 border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-300 dark:placeholder:text-slate-500 focus:outline-none focus:border-blue-400 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200">
    </div>

    {{-- Bank & No Rekening side by side on desktop --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="group">
            <label class="flex items-center gap-2 text-sm font-semibold mb-2 text-slate-500 dark:text-slate-400 group-focus-within:text-blue-500 dark:group-focus-within:text-blue-400 transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Bank
            </label>
            <input type="text" name="bankpenerima"
                   value="{{ old('bankpenerima', $penerima->bankpenerima ?? '') }}"
                   placeholder="Nama bank"
                   class="w-full border-2 border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-300 dark:placeholder:text-slate-500 focus:outline-none focus:border-blue-400 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200">
        </div>

        <div class="group">
            <label class="flex items-center gap-2 text-sm font-semibold mb-2 text-slate-500 dark:text-slate-400 group-focus-within:text-blue-500 dark:group-focus-within:text-blue-400 transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                No Rekening
            </label>
            <input type="text" name="norek_penerima"
                   value="{{ old('norek_penerima', $penerima->norek_penerima ?? '') }}"
                   placeholder="Nomor rekening"
                   class="w-full border-2 border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-300 dark:placeholder:text-slate-500 focus:outline-none focus:border-blue-400 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 font-mono">
        </div>
    </div>

    {{-- Alamat --}}
    <div class="group">
        <label class="flex items-center gap-2 text-sm font-semibold mb-2 text-slate-500 dark:text-slate-400 group-focus-within:text-blue-500 dark:group-focus-within:text-blue-400 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Alamat
        </label>
        <textarea name="alamat"
                  rows="3"
                  placeholder="Masukkan alamat lengkap penerima"
                  class="w-full border-2 border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-300 dark:placeholder:text-slate-500 focus:outline-none focus:border-blue-400 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 resize-none">{{ old('alamat', $penerima->alamat ?? '') }}</textarea>
    </div>

</div>
