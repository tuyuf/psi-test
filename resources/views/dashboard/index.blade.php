@extends('layouts.main')

@section('container')
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    <h2 class="mb-5 text-primary">Selamat Datang, {{ auth()->user()->name }}</h2>
    <div class="d-flex flex-column align-items-center">
        <div class="alert alert-primary p-4 ">
            <p>
                Yth. Bapak/Ibu, saudara/i
            </p>
            <p>Kami dari tim Jasa Psikologi Fakultas Psikologi Universitas Diponegoro, meminta kesediaan Bapak/Ibu, Saudara/i  
                dalam memberikan jawaban kondisi kesehatan mental saat ini.
                Tujuan dilakukannya pengisian aplikasi ini adalah untuk memahami kondisi kesehatan mental secara berkala
                pada Universitas Diponegoro.</p>
            <div class="alert alert-warning">
                <h5 class="alert-heading">Disclaimer</h5>
                <hr>
                 Hasil Skrining tes Kesehatan mental ini tidak akan mempengaruhi nilai bahkan saat masa studi dan juga bukan diagnosa klinis, 
                 tetapi merupakan gambaran kondisi Kesehatan mental anda saat ini.
                 <br>
                 <br>
                 Apabila anda ingin mengetahui lebih lanjut diagnosa dan penjelasan mengenai Kondisi Kesehatan mental, 
                 Anda disarankan untuk menemui professional Kesehatan mental (psikolog klinis/psikiater) yang anda percaya dengan membawa hasil skrining ini.
            </div>
            <p>Hasil pengisian aplikasi ini tidak ada kaitannya dengan penilaian mahasiswa/ karyawan yang dilakukan oleh
                Fakultas, Universitas maupun atasan.
                Namun, Bapak/Ibu/ Saudara/Saudari akan memperoleh hasil gambaran kondisi kesehatan mental Bapak/Ibu beserta rekomendasinya
                untuk dapat mengelola maupun meningkatkan kesejahteraan psikologis Bapak/Ibu.</p>

            <p>Semua data yang disampaikan bersifat <em>anonymous</em> dan rahasia. Hanya pihak psikolog pemberi layanan
                kesehatan
                mental yang dapat mengakses data Bapak/Ibu dibawah sumpah kode etik profesi psikolog.</p>

            {{-- Hak dan kewajiban anda. --}}
                {{-- <br>
                <br> --}}
            <p>⁠Anda diharapkan mencentang pernyataan dibawah ini apabila setuju untuk melanjutkan ke aplikasi
                    skrining.</p>
            {{-- <ol>
                <li>⁠Anda diharapkan mencentang pernyataan dibawah ini apabila setuju untuk melanjutkan ke aplikasi
                    skrining.</li>
                <li>⁠Anda diharapkan mencentang setuju apabila berkenan untuk melanjutkan hasil skrining tersebut pada
                    tindakan
                    pendampingan kesehatan mental yang akan dilakukan oleh tim kesehatan mental Universitas Diponegoro.</li>
            </ol> --}}
            <div class="form-check mt-4">
                <input class="form-check-input agreement-checkbox" type="checkbox" id="setuju1">
                <label class="form-check-label" for="setuju1">
                    Saya setuju untuk melanjutkan ke aplikasi skrining.
                </label>
            </div>
            {{-- <div class="form-check ">
                <input class="form-check-input agreement-checkbox" type="checkbox" value="" id="setuju2">
                <label class="form-check-label" for="setuju2">
                    Saya setuju untuk melanjutkan hasil skrining tersebut pada tindakan pendampingan kesehatan mental yang
                    akan dilakukan oleh tim kesehatan mental Universitas Diponegoro.
                </label>
            </div> --}}
        </div>

        @if (auth()->user()->hasUnfinishedHasil())
            <h5 class="mb-3 text-primary">Anda belum menyelesaikan tes terakhir anda, mohon klik tomboh di bawah ini untuk
                melanjutkan tes.</h5>
            <a href="{{ route('resume-test') }}" class="btn btn-primary">Lanjutkan Tes <i
                    class="fas fa-arrow-right"></i></a>
        @else
            <h5 class="mb-3 text-primary">Untuk memulai tes, silakan klik tombol di bawah ini </h5>
            <div class="d-flex justify-content-between align-items-center">
                <form action="{{ route('test-ghq') }}" method="GET">
                    <button type="submit" id="startButton" class="btn btn-primary d-block mb-3" disabled>Mulai Tes <i
                            class="fas fa-arrow-right"></i></button>
                </form>
                @if (auth()->user()->hasil->count())
                    <p class="mx-3 text-primary">Atau</p>
                    <a href="{{ route('hasil.index') }}" class="btn btn-primary d-block mb-3">Lihat Riwayat Tes <i
                            class="fas fa-file-medical-alt"></i></a>
                @endif
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        // Ambil semua checkbox dan tombol
        const checkboxes = document.querySelectorAll('.agreement-checkbox');
        const startButton = document.getElementById('startButton');

        // Fungsi untuk mengecek apakah semua checkbox sudah dicentang
        function checkAllChecked() {
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            startButton.disabled = !allChecked;
        }

        // Tambahkan event listener ke setiap checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', checkAllChecked);
        });
    </script>
@endsection
