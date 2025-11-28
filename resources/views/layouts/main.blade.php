@extends('app')

@section('content')
<div id="wrapper">
    @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('components.navbar')
            <div class="card shadow-sm p-3 m-3 min-vh-100">
                @yield('container')
            </div>
        </div>
    </div>
</div>

{{-- Modal Lengkapi Profil --}}
@if(session('incomplete_profile'))
    <div class="modal fade" id="profileModal" tabindex="-1"
        aria-labelledby="profileModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="profileModalLabel">Lengkapi Profil Anda</h5>
                </div>
                <div class="modal-body">
                    Beberapa data profil Anda masih kosong.
                    Silakan lengkapi profil agar dapat melanjutkan.
                </div>
                <div class="modal-footer">
                    <a href="{{ route('profile') }}" class="btn btn-primary">Lengkapi Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var profileModal = new bootstrap.Modal(document.getElementById('profileModal'), {
                backdrop: 'static',
                keyboard: false
            });
            profileModal.show();
        });
    </script>
@endif

@endsection
