@extends('layouts.main')

@section('container')
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="d-flex justify-content-between">
        <h2 class="mb-4 text-primary">Edit Profil Saya</h2>
        <div class="">
            <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <form class="user" method="POST" action="{{ route('profile.update',['user' => $user]) }}">
        @method('PUT')
        @csrf
        <div class="form-group">
        <div class="form-group">
    <small class="form-text text-muted ml-3">Email UNDIP</small>
    <input class="form-control form-control-user @error('email') is-invalid @enderror"
        name="email" placeholder="contoh@undip.ac.id"
        value="{{ old('email') ?? $user->email }}">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <small class="form-text text-muted ml-3">Email Alternatif (Opsional)</small>
    <input class="form-control form-control-user @error('alternate_email') is-invalid @enderror"
        name="alternate_email" placeholder="contoh@gmail.com"
        value="{{ old('alternate_email') ?? $user->alternate_email }}">
    @error('alternate_email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <small class="form-text text-muted ml-3">NIP (Username)</small>
    <input class="form-control form-control-user @error('username') is-invalid @enderror"
        name="username" placeholder="Masukkan NIP"
        value="{{ old('username') ?? $user->username }}">
    @error('username')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <small class="form-text text-muted ml-3">Nama Lengkap / Inisial</small>
    <input class="form-control form-control-user @error('name') is-invalid @enderror"
        name="name" placeholder="Masukkan nama atau inisial"
        value="{{ old('name') ?? $user->name }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<small class="form-text text-muted ml-3">Jenis Kelamin</small>
<div class="d-flex justify-content-around mb-3">
    <div class="form-check">
        <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
            type="radio" name="jenis_kelamin" value="laki-laki"
            @checked(old('jenis_kelamin') ? old('jenis_kelamin') == 'laki-laki' : $user->jenis_kelamin == 'laki-laki')>
        <label class="form-check-label">Laki-Laki</label>
    </div>
    <div class="form-check">
        <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
            type="radio" name="jenis_kelamin" value="perempuan"
            @checked(old('jenis_kelamin') ? old('jenis_kelamin') == 'perempuan' : $user->jenis_kelamin == 'perempuan')>
        <label class="form-check-label">Perempuan</label>
    </div>
    @error('jenis_kelamin')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<small class="form-text text-muted ml-3 mb-1">Usia</small>
<div class="form-group">
    <input class="form-control form-control-user @error('usia') is-invalid @enderror"
        type="number" name="usia" placeholder="Masukkan usia (tahun)"
        value="{{ old('usia') ?? $user->usia }}">
    @error('usia')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<small class="form-text text-muted ml-3 mb-1">Masa kerja</small>
<div class="form-group">
    <input class="form-control form-control-user @error('masa_kerja') is-invalid @enderror"
        type="number" name="masa_kerja" placeholder="Masukkan lama kerja (tahun)"
        value="{{ old('masa_kerja') ?? $user->masa_kerja }}">
    @error('masa_kerja')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<small class="form-text text-muted ml-3 mb-1">Unit kerja</small>
<div class="form-group">
    <select name="unit_kerja"
        class="form-control @error('unit_kerja') is-invalid @enderror"
        style="border-radius: 10rem; height: 3.5rem; padding: 0 1rem; font-size: 0.9rem; line-height: 2rem;">
        <option value="" disabled {{ old('unit_kerja', $user->unit_kerja ?? '') == '' ? 'selected' : '' }}>Pilih unit kerja</option>
        <option value="Kantor Pusat" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Kantor Pusat' ? 'selected' : '' }}>Kantor Pusat</option>
        <option value="Fakultas Teknik" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Teknik' ? 'selected' : '' }}>Fakultas Teknik</option>
        <option value="Fakultas Peternakan dan Pertanian" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Peternakan dan Pertanian' ? 'selected' : '' }}>Fakultas Peternakan dan Pertanian</option>
        <option value="Fakultas Perikanan dan Ilmu Kelautan" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Perikanan dan Ilmu Kelautan' ? 'selected' : '' }}>Fakultas Perikanan dan Ilmu Kelautan</option>
        <option value="Fakultas Psikologi" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Psikologi' ? 'selected' : '' }}>Fakultas Psikologi</option>
        <option value="Fakultas Sain dan Matematika" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Sain dan Matematika' ? 'selected' : '' }}>Fakultas Sain dan Matematika</option>
        <option value="Fakultas Kedokteran" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Kedokteran' ? 'selected' : '' }}>Fakultas Kedokteran</option>
        <option value="Fakultas Kesehatan Masyarakat" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Kesehatan Masyarakat' ? 'selected' : '' }}>Fakultas Kesehatan Masyarakat</option>
        <option value="Fakultas Ekonomika dan Bisnis" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Ekonomika dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomika dan Bisnis</option>
        <option value="Fakultas Hukum" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Hukum' ? 'selected' : '' }}>Fakultas Hukum</option>
        <option value="Fakultas Ilmu Sosial dan Ilmu Politik" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Ilmu Sosial dan Ilmu Politik' ? 'selected' : '' }}>Fakultas Ilmu Sosial dan Ilmu Politik</option>
        <option value="Fakultas Ilmu Budaya" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Fakultas Ilmu Budaya' ? 'selected' : '' }}>Fakultas Ilmu Budaya</option>
        <option value="Sekolah Vokasi" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Sekolah Vokasi' ? 'selected' : '' }}>Sekolah Vokasi</option>
        <option value="Sekolah Pasca Sarjana" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'Sekolah Pasca Sarjana' ? 'selected' : '' }}>Sekolah Pasca Sarjana</option>
        <option value="PSDKU" {{ old('unit_kerja', $user->unit_kerja ?? '') == 'PSDKU' ? 'selected' : '' }}>PSDKU</option>
    </select>
    @error('unit_kerja')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<small class="form-text text-muted ml-3 mb-1">Alamat / Domisili</small>
<div class="form-group">
    <input class="form-control form-control-user @error('alamat') is-invalid @enderror"
        name="alamat" placeholder="Masukkan alamat / domisili"
        value="{{ old('alamat') ?? $user->alamat }}">
    @error('alamat')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<small class="form-text text-muted ml-3 mb-1">Nomor telepon (Opsional)</small>
<div class="form-group">
    <input class="form-control form-control-user @error('telepon') is-invalid @enderror"
        name="telepon" placeholder="08xxxxxxxxxx"
        value="{{ old('telepon') ?? $user->telepon }}">
    @error('telepon')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<small class="form-text text-muted ml-3 mb-1">Riwayat Kesehatan/Psikiatri</small>
<div class="form-group">
    <input class="form-control form-control-user @error('health_history') is-invalid @enderror"
        name="health_history" placeholder="Tuliskan riwayat kesehatan/psikiatri jika ada"
        value="{{ old('health_history') ?? $user->health_history }}">
    @error('health_history')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Password Baru --}}
<small class="form-text text-muted ml-3 mb-1">Password Baru</small>
<div class="form-group">
    <input type="password"
        class="form-control form-control-user @error('password') is-invalid @enderror"
        name="password"
        placeholder="Kosongkan jika tidak ingin mengganti password"
        autocomplete="new-password">
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Konfirmasi Password Baru --}}
<small class="form-text text-muted ml-3 mb-1">Konfirmasi Password Baru</small>
<div class="form-group">
    <input type="password"
        class="form-control form-control-user"
        name="password_confirmation"
        placeholder="Ulangi password baru"
        autocomplete="new-password">
</div>

        <button class="btn btn-primary btn-user btn-block" type="submit">Simpan Perubahan</button>
    </form>
@endsection
