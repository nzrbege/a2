<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Http\Request;

class PenerimaController extends Controller
{
    public function index()
    {
        $penerimas = Penerima::orderBy('id', 'desc')->paginate(10);
        return view('penerima.index', compact('penerimas'));
    }

    public function create()
    {
        return view('penerima.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'penerima' => 'required|string|max:255',
            'npwp' => 'nullable|string|max:50',
            'bankpenerima' => 'required|string|max:255',
            'norek_penerima' => 'required|string|max:100',
            'alamat' => 'required|string',
        ]);

        Penerima::create($validated);

        return redirect()->route('penerima.index')
            ->with('success', 'Data penerima berhasil ditambahkan');
    }

    public function show(Penerima $penerima)
    {
        return view('penerima.show', compact('penerima'));
    }

    public function edit(Penerima $penerima)
    {
        return view('penerima.edit', compact('penerima'));
    }

    public function update(Request $request, Penerima $penerima)
    {
        $validated = $request->validate([
            'penerima' => 'required|string|max:255',
            'npwp' => 'nullable|string|max:50',
            'bankpenerima' => 'required|string|max:255',
            'norek_penerima' => 'required|string|max:100',
            'alamat' => 'required|string',
        ]);

        $penerima->update($validated);

        return redirect()->route('penerima.index')
            ->with('success', 'Data penerima berhasil diupdate');
    }

    public function destroy(Penerima $penerima)
    {
        $penerima->delete();

        return redirect()->route('penerima.index')
            ->with('success', 'Data penerima berhasil dihapus');
    }
}