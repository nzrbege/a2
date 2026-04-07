<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Http\Request;

class PenerimaController extends Controller
{
    public function index(Request $request)
    {
        $query = Penerima::query();

        // ── Global search ──────────────────────────────────
        if ($q = $request->q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('penerima',       'like', "%{$q}%")
                    ->orWhere('npwp',          'like', "%{$q}%")
                    ->orWhere('bankpenerima',  'like', "%{$q}%")
                    ->orWhere('norek_penerima','like', "%{$q}%")
                    ->orWhere('alamat',        'like', "%{$q}%");
            });
        }

        // ── Filter per kolom ──────────────────────────────
        if ($v = $request->f_nama)   $query->where('penerima',        'like', "%{$v}%");
        if ($v = $request->f_npwp)   $query->where('npwp',            'like', "%{$v}%");
        if ($v = $request->f_bank)   $query->where('bankpenerima',    'like', "%{$v}%");
        if ($v = $request->f_norek)  $query->where('norek_penerima',  'like', "%{$v}%");
        if ($v = $request->f_alamat) $query->where('alamat',          'like', "%{$v}%");

        // ── Sort ──────────────────────────────────────────
        $allowedSorts = ['penerima', 'npwp', 'bankpenerima', 'norek_penerima', 'alamat'];
        $sort  = in_array($request->sort, $allowedSorts) ? $request->sort : 'penerima';
        $order = $request->order === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sort, $order);

        // ── Per page ──────────────────────────────────────
        $perPage = in_array((int) $request->per_page, [10, 25, 50, 100])
            ? (int) $request->per_page
            : 10;

        $penerimas = $query->paginate($perPage)->withQueryString();

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