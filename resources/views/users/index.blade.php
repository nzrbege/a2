@extends('layouts.app')

@section('content')
<div class="p-4">
    <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User</a>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{ route('users.edit', $user) }}">Edit</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
                <form action="{{ route('users.resetPassword', $user) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Reset Password</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $users->links() }}
</div>
@endsection