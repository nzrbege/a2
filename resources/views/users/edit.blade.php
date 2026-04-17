@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf @method('PUT')
    <input type="text" name="name" value="{{ $user->name }}"><br>
    <input type="email" name="email" value="{{ $user->email }}"><br>
    <button type="submit">Update</button>
</form>
@endsection