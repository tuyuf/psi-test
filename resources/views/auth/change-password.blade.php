@extends('app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 p-4">
            {{-- Header Logo & Judul --}}
            <div class="text-center mb-4">
                <img src="{{ asset('img/Logo JAPSI.png') }}" alt="Logo JAPSI" class="img-fluid mb-3" style="max-height: 80px;">
                <h3 class="font-weight-bold text-gray-900">Ubah Password</h3>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('password.change.submit') }}">
            @csrf

            {{-- NIP --}}
            <div class="form-group mb-3">
                <label for="username">NIP / NIM</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username') }}" placeholder="Masukkan NIP / NIM">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email UNDIP --}}
            <div class="form-group mb-3">
                <label for="email">Email UNDIP</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="contoh@undip.ac.id">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="form-group mb-3">
                <label for="password">Password Baru</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Minimal 8 karakter">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-group mb-4">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="Ulangi password baru">
            </div>

            {{-- Tombol Ubah Password Warna Pink Soft --}}
            <button type="submit" class="btn btn-block text-white font-weight-bold" style="background-color: #da728a; border-color: #da728a;">Ubah Password</button>
        </form>

        <hr>

        {{-- Link Kembali ke Login --}}
        <p class="text-center m-0 p-0">
            Sudah ingat password? <a href="{{ route('login') }}">Kembali ke Login</a>
        </p>
        </div>
    </div>
</div>
@endsection