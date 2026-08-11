@extends('app')

@section('content')
    {{-- Pesan error login --}}
    @if (session('loginError'))
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            {{ session('loginError') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    {{-- Pesan sukses (misalnya setelah ubah password) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body">
                    <div class="text-center mb-4">
                        {{-- Elemen Logo Tambahan --}}
                        <img src="{{ asset('img/Logo-JAPSI.png?v=2') }}" alt="Logo JAPSI" class="img-fluid mb-3" style="max-height: 90px;">
                        
                        <h1 class="h4 text-gray-900 font-weight-bold">Selamat Datang di Screening Mental Health!</h1>
                    </div>

                    <form class="user" method="POST" action="{{ route('authenticate') }}">
                        @csrf
                        <div class="form-group">
                            <input
                                class="form-control form-control-user @error('username') is-invalid @enderror"
                                name="username"
                                placeholder="NIM (Username)"
                                value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password"
                                name="password"
                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                placeholder="Password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Login Warna Pink Soft --}}
                        <button class="btn btn-user btn-block text-white font-weight-bold" type="submit" style="background-color: #da728a; border-color: #da728a;">Login</button>
                    </form>

                    <hr>

                    {{-- Link Ubah Password --}}
                    <p class="text-center mt-3">
                        Lupa password? <a href="{{ route('password.change.form') }}">Ubah Password</a>
                    </p>

                    {{-- Link Registrasi --}}
                    <p class="text-center m-0 p-0">
                        Belum Memiliki Akun? <a href="{{ route('register') }}">Daftar Disini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white py-3">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Jasa Psikologi - Fakultas Psikologi Undip @2026</span>
            </div>
        </div>
    </footer>
@endsection