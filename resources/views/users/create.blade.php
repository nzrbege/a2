@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('users.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Nama"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <button type="submit">Simpan</button>
</form>
@endsection