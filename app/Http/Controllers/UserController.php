<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Opd;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['opd', 'unit'])->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $opds   = Opd::orderBy('nama_opd')->get();
        $units = Unit::orderBy('nama_unit')->get();
        return view('users.create', compact('opds', 'units'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:superadmin,admin,user',
            'id_opd'   => 'nullable|exists:opd,id',
            'unit_id'  => 'nullable|exists:unit,id',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'opd_id'   => $request->id_opd,
            'unit_id'  => $request->unit_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $opds    = Opd::orderBy('nama_opd')->get();
        $units   = Unit::orderBy('nama_unit')->get();
        return view('users.edit', compact('user', 'opds', 'units'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:superadmin,admin,user',
            'id_opd'   => 'nullable|exists:opd,id',
            'unit_id'  => 'nullable|exists:unit,id',
        ]);

        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => $request->role,
            'opd_id'   => $request->id_opd,
            'unit_id'=> $request->unit_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(8);

        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return back()->with(
            'success',
            'Password berhasil direset untuk user: ' . $user->username . ' | Password baru: ' . $newPassword
        );
    }
}
