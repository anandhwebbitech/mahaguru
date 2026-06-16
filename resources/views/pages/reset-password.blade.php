@extends('layouts.app')
 @section('content')

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <input type="email" name="email" placeholder="Enter your email" required>

    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

    <button type="submit">Reset Password</button>

    @error('email')
        <p>{{ $message }}</p>
    @enderror
</form>

 @endsection