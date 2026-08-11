@extends('app')

@section('content')
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pt-4 pb-4 px-5">
                                    <div class="text-center">
                                        {{-- Elemen Logo JAPSI --}}
                                        <img src="{{ asset('img/Logo-JAPSI.png?v=2') }}" alt="Logo JAPSI" class="img-fluid mb-3" style="max-height: 80px;">

                                        <h1 class="h4 text-gray-900 font-weight-bold mb-3">Verifikasi Email Anda</h1>
                                        <p class="text-muted mb-2">
                                            Kami telah mengirimkan email verifikasi ke alamat:
                                        </p>
                                        <p class="font-weight-bold mb-3" style="color: #da728a;">
                                            {{ auth()->user()->email }}
                                        </p>
                                        <p class="text-muted mb-4">
                                            Silakan periksa kotak masuk email Anda untuk melakukan verifikasi.
                                        </p>
                                        <p class="text-muted mb-3">
                                            Tidak menerima email?
                                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline font-weight-bold" style="color: #da728a; text-decoration: none;">
                                                Kirim ulang email verifikasi
                                            </button>
                                        </form>
                                        </p>
                                    </div>
                                    <hr>
                                    <p class="text-center m-0 p-0">Sudah Memiliki Akun? <a href="{{ route('login') }}" style="color: #da728a;">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <footer class="sticky-footer bg-white py-3">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Jasa Psikologi - Fakultas Psikologi Undip @2026</span>
                </div>
            </div>
        </footer>
    </div>
@endsection