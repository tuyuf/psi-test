@extends('layouts.main')

@section('container')
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    <h2 class="mb-4 text-primary">Buat User</h2>
    <form class="user" method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="form-group">
            <small class="form-text text-muted ml-3">Email UNDIP</small>
            <input class="form-control form-control-user @error('email') is-invalid @enderror"
                name="email" placeholder="contoh@undip.ac.id" value="{{ old('email') }}">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <small class="form-text text-muted ml-3">Email Alternatif (Opsional)</small>
            <input class="form-control form-control-user @error('alternate_email') is-invalid @enderror"
                name="alternate_email" placeholder="contoh@gmail.com"
                value="{{ old('alternate_email')}}">
            @error('alternate_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <small class="form-text text-muted ml-3">NIP / NIM (Username)</small>
            <input class="form-control form-control-user @error('username') is-invalid @enderror"
                name="username" placeholder="Masukkan NIP" value="{{ old('username') }}">
            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <small class="form-text text-muted ml-3">Nama Lengkap / Inisial</small>
            <input class="form-control form-control-user @error('name') is-invalid @enderror"
                name="name" placeholder="Masukkan nama atau inisial" value="{{ old('name') }}">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <small class="form-text text-muted ml-3">Jenis Kelamin</small>
        <div class="d-flex justify-content-around mb-3">
            <div class="form-check">
                <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                    type="radio" name="jenis_kelamin" value="laki-laki"
                    @checked(old('jenis_kelamin') == 'laki-laki')>
                <label class="form-check-label">Laki-Laki</label>
            </div>
            <div class="form-check">
                <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                    type="radio" name="jenis_kelamin" value="perempuan"
                    @checked(old('jenis_kelamin') == 'perempuan')>
                <label class="form-check-label">Perempuan</label>
            </div>
        </div>

        <small class="form-text text-muted ml-3 mb-1">Usia</small>
        <div class="form-group">
            <input class="form-control form-control-user @error('usia') is-invalid @enderror"
                type="number" name="usia" placeholder="Masukkan usia (tahun)" value="{{ old('usia') }}">
            @error('usia') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <small class="form-text text-muted ml-3 mb-1">Angkatan</small>
        <div class="form-group">
            <input class="form-control form-control-user @error('masa_kerja') is-invalid @enderror"
                type="number" name="masa_kerja" placeholder="Masukkan angkatan (tahun)" value="{{ old('masa_kerja') }}">
            @error('masa_kerja') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <small class="form-text text-muted ml-3 mb-1">Unit kerja / Fakultas</small>
        <div class="form-group">
            <select name="unit_kerja"
                class="form-control @error('unit_kerja') is-invalid @enderror"
                style="border-radius: 10rem; height: 3.5rem; padding: 0 1rem; font-size: 0.9rem; line-height: 2rem;">
                <option value="" disabled selected>Pilih unit kerja</option>

                <option value="Kantor Pusat">Kantor Pusat</option>
                <option value="Fakultas Teknik">Fakultas Teknik</option>
                <option value="Fakultas Peternakan dan Pertanian">Fakultas Peternakan dan Pertanian</option>
                <option value="Fakultas Perikanan dan Ilmu Kelautan">Fakultas Perikanan dan Ilmu Kelautan</option>
                <option value="Fakultas Psikologi">Fakultas Psikologi</option>
                <option value="Fakultas Sain dan Matematika">Fakultas Sain dan Matematika</option>
                <option value="Fakultas Kedokteran">Fakultas Kedokteran</option>
                <option value="Fakultas Kesehatan Masyarakat">Fakultas Kesehatan Masyarakat</option>
                <option value="Fakultas Ekonomika dan Bisnis">Fakultas Ekonomika dan Bisnis</option>
                <option value="Fakultas Hukum">Fakultas Hukum</option>
                <option value="Fakultas Ilmu Sosial dan Ilmu Politik">Fakultas Ilmu Sosial dan Ilmu Politik</option>
                <option value="Fakultas Ilmu Budaya">Fakultas Ilmu Budaya</option>
                <option value="Sekolah Vokasi">Sekolah Vokasi</option>
                <option value="Sekolah Pasca Sarjana">Sekolah Pasca Sarjana</option>
                <option value="PSDKU">PSDKU</option>

                <!-- Tambahan -->
                <option value="Lembaga Pengembangan dan Penjaminan Mutu Pendidikan (LP2MP)">Lembaga Pengembangan dan Penjaminan Mutu Pendidikan (LP2MP)</option>
                <option value="Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM)">Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM)</option>

                <option value="Badan Pengelola Kampus di Luar Kampus Utama">Badan Pengelola Kampus di Luar Kampus Utama</option>
                <option value="Badan Pengelola Kampus Jepara">Badan Pengelola Kampus Jepara</option>
                <option value="Badan Perencanaan dan Pengembangan (BPP)">Badan Perencanaan dan Pengembangan (BPP)</option>
                <option value="Badan Pengelola Usaha, Bisnis Komersial dan Analisis Risiko (BP UBIKAR)">Badan Pengelola Usaha, Bisnis Komersial dan Analisis Risiko (BP UBIKAR)</option>

                <option value="Direktorat Akademik">Direktorat Akademik</option>
                <option value="Direktorat Kemahasiswaan dan Alumni">Direktorat Kemahasiswaan dan Alumni</option>
                <option value="Direktorat Keuangan, Akuntansi dan Perpajakan">Direktorat Keuangan, Akuntansi dan Perpajakan</option>
                <option value="Direktorat Aset dan Perancangan">Direktorat Aset dan Perancangan</option>
                <option value="Direktorat Sumber Daya Manusia">Direktorat Sumber Daya Manusia</option>
                <option value="Direktorat Sistem dan Teknologi Informasi">Direktorat Sistem dan Teknologi Informasi</option>
                <option value="Direktorat Hukum dan Organisasi">Direktorat Hukum dan Organisasi</option>
                <option value="Direktorat Inovasi, Hilirisasi dan Kerja Sama">Direktorat Inovasi, Hilirisasi dan Kerja Sama</option>
                <option value="Direktorat Reputasi, Kemitraan dan Konektivitas Global">Direktorat Reputasi, Kemitraan dan Konektivitas Global</option>
                <option value="Direktorat Jejaring Media, Komunitas dan Komunikasi Publik">Direktorat Jejaring Media, Komunitas dan Komunikasi Publik</option>

                <option value="Biro Ketatausahaan dan Kerumahtanggaan">Biro Ketatausahaan dan Kerumahtanggaan</option>

                <option value="Kantor Kawasan Hutan dengan Tujuan Khusus (KHDTK)">Kantor Kawasan Hutan dengan Tujuan Khusus (KHDTK)</option>
                <option value="Kantor Kearsipan">Kantor Kearsipan</option>
                <option value="Kantor Pengadaan Barang dan Jasa">Kantor Pengadaan Barang dan Jasa</option>
                <option value="Kantor Prestasi dan Fasilitasi Bisnis Mahasiswa">Kantor Prestasi dan Fasilitasi Bisnis Mahasiswa</option>

                <option value="UPT Laboratorium Terpadu">UPT Laboratorium Terpadu</option>
                <option value="UPT Perpustakaan dan Undip Press">UPT Perpustakaan dan Undip Press</option>
                <option value="UPT Keselamatan, Kesehatan Kerja dan Lingkungan (UPT K3L)">UPT Keselamatan, Kesehatan Kerja dan Lingkungan (UPT K3L)</option>
                <option value="UPT Layanan Konsultasi, Disabilitas, Penegakan Disiplin dan Etika Mahasiswa">UPT Layanan Konsultasi, Disabilitas, Penegakan Disiplin dan Etika Mahasiswa</option>
                <option value="UPT Layanan Seni, Budaya dan Olahraga">UPT Layanan Seni, Budaya dan Olahraga</option>

                <option value="Rumah Sakit Nasional Diponegoro (RSND)">Rumah Sakit Nasional Diponegoro (RSND)</option>
            </select>
            @error('unit_kerja')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <small class="form-text text-muted ml-3 mb-1">Alamat / Domisili</small>
        <div class="form-group">
            <input class="form-control form-control-user @error('alamat') is-invalid @enderror"
                name="alamat" placeholder="Masukkan alamat / domisili" value="{{ old('alamat') }}">
            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <small class="form-text text-muted ml-3 mb-1">Nomor telepon (Opsional)</small>
        <div class="form-group">
            <input class="form-control form-control-user @error('telepon') is-invalid @enderror"
                name="telepon" placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}">
            @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <small class="form-text text-muted ml-3 mb-1">Riwayat Kesehatan/Psikiatri (Opsional)</small>
        <div class="form-group">
            <input class="form-control form-control-user @error('health_history') is-invalid @enderror"
                name="health_history" placeholder="Tuliskan riwayat kesehatan/psikiatri jika ada " value="{{ old('health_history') }}">
            @error('health_history') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <small class="form-text text-muted ml-3 mb-1">Role</small>
        <div class="form-group">
            <select name="role" class="form-control @error('role') is-invalid @enderror">
                <option value="1" @selected(old('role') == 1)>User</option>
                <option value="2" @selected(old('role') == 2)>Admin</option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <small class="form-text text-muted ml-3 mb-1">Password</small>
            <input type="password" name="password"
                class="form-control form-control-user @error('password') is-invalid @enderror"
                placeholder="Minimal 8 karakter">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <input type="password" name="password_confirmation"
                class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                placeholder="Konfirmasi Password">
            @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary btn-user btn-block" type="submit">Buat User</button>
    </form>
@endsection
