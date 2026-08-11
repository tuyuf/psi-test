@extends('layouts.main')

@section('container')
    <!-- Breadcrumb -->
    <div class="row mb-3">
        <div class="col">
            {{ Breadcrumbs::render() }}
        </div>
    </div>

    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-primary">Rekap Hasil Tes</h2>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ request('tab') !== 'table' ? 'active' : '' }}" id="dashboard-tab" data-toggle="tab" data-target="#dashboard" type="button"
                role="tab" aria-controls="dashboard" aria-selected="{{ request('tab') !== 'table' ? 'true' : 'false' }}">Dashboard</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ request('tab') === 'table' ? 'active' : '' }}" id="table-tab" data-toggle="tab" data-target="#table" type="button" role="tab"
                aria-controls="table" aria-selected="{{ request('tab') === 'table' ? 'true' : 'false' }}">Tabel</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        {{-- TAB DASHBOARD --}}
        <div class="tab-pane fade {{ request('tab') !== 'table' ? 'show active' : '' }}" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="container-fluid py-4">
                <div class="d-flex flex-column align-items-center">
                    <p>Filter data menurut tanggal</p>
                    <form class="form-inline mb-3" id="filterForm">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="inputStartDate" class="sr-only">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="inputStartDate" placeholder="Tanggal Mulai">
                        </div>
                        <p>Hingga</p>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="inputEndDate" class="sr-only">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="inputEndDate" placeholder="Tanggal Selesai">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Filter</button>
                    </form>
                </div>

                {{-- Charts Row 1: Card summary --}}
                <div class="row mb-3">
                    {{-- Jumlah Responden Tes --}}
                    <div class="col mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="text-dark" style="font-weight: 600" id="jumlahResponden"></h3>
                                <h6 class="text-dark" style="font-weight: 600">Responden Tes</h6>
                            </div>
                        </div>
                    </div>

                    {{-- Jumlah Rangkaian Tes yang dikerjakan  --}}
                    <div class="col mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="text-dark" style="font-weight: 600" id="jumlahTes"></h3>
                                <h6 class="text-dark" style="font-weight: 600">Rangkaian Tes Dikerjakan</h6>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Charts Row 2: jumlah tes per instrumen --}}
                <div class="row mb-3">
                    {{-- Jumlah Tes GHQ yang dikerjakan  --}}
                    <div class="col mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="text-dark" style="font-weight: 600" id="jumlahGHQ"></h3>
                                <h6 class="text-dark" style="font-weight: 600">Peserta Mengerjakan Tes GHQ-12</h6>
                            </div>
                        </div>
                    </div>
                    {{-- Jumlah Tes DASS-21 yang dikerjakan  --}}
                    <div class="col mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="text-dark" style="font-weight: 600" id="jumlahDASS21"></h3>
                                <h6 class="text-dark" style="font-weight: 600">Peserta Mengerjakan Tes DASS-21</h6>
                            </div>
                        </div>
                    </div>
                    {{-- Jumlah Tes HSCL-25 yang dikerjakan  --}}
                    <div class="col mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="text-dark" style="font-weight: 600" id="jumlahHSCL25"></h3>
                                <h6 class="text-dark" style="font-weight: 600">Peserta Mengerjakan Tes HSCL-25</h6>
                            </div>
                        </div>
                    </div>
                    {{-- Jumlah Tes HTQ yang dikerjakan  --}}
                    <div class="col mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="text-dark" style="font-weight: 600" id="jumlahHTQ"></h3>
                                <h6 class="text-dark" style="font-weight: 600">Peserta Mengerjakan Tes HTQ</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row 3: GHQ & DASS21 -->
                <div class="row mb-3">
                    <!-- GHQ Chart -->
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <canvas id="ghqChart" style="height: 300px"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- DASS21 Chart -->
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <canvas id="dass21Chart" style="height: 300px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Charts Row 4: HSCL & HTQ --}}
                <div class="row">
                    <!-- HSCL25 Chart -->
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <canvas id="hscl25Chart" style="height: 300px"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- HTQ Chart -->
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <canvas id="htqChart" style="height: 300px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== DEMOGRAFI ===================== --}}
                {{-- Row: Card total laki / perempuan --}}
                <div class="row mt-4 mb-3">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="text-dark" style="font-weight: 600" id="totalLaki">0</h3>
                                <h6 class="text-dark" style="font-weight: 600">Responden Laki-laki</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="text-dark" style="font-weight: 600" id="totalPerempuan">0</h3>
                                <h6 class="text-dark" style="font-weight: 600">Responden Perempuan</h6>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Row: Jenis Kelamin & Usia --}}
                <div class="row mb-3">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <canvas id="genderChart" style="height:300px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <canvas id="usiaChart" style="height:300px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Row: Angkatan & Unit Kerja --}}
                <div class="row mb-3">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <canvas id="masaKerjaChart" style="height:300px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <canvas id="unitKerjaChart" style="height:300px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ===================================================== --}}
            </div>
        </div>

        {{-- TAB TABEL --}}
        <div class="tab-pane fade {{ request('tab') === 'table' ? 'show active' : '' }}" id="table" role="tabpanel" aria-labelledby="table-tab">
            <div class="mt-3">
                <form method="GET" action="{{ route('admin.rekap') }}" id="tableFilterForm">
                    <input type="hidden" name="tab" value="table">

                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tableStartDate">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tableStartDate" name="start_date" value="{{ $startDate ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tableEndDate">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tableEndDate" name="end_date" value="{{ $endDate ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tableSearch">Cari Nama</label>
                                <input type="text" class="form-control" id="tableSearch" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama responden...">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tableLastTest">Jenis Tes Terakhir</label>
                                <select class="form-control" id="tableLastTest" name="last_test">
                                    <option value="">Semua</option>
                                    <option value="ghq12" {{ ($lastTest ?? '') === 'ghq12' ? 'selected' : '' }}>GHQ-12</option>
                                    <option value="dass-21" {{ ($lastTest ?? '') === 'dass-21' ? 'selected' : '' }}>DASS-21</option>
                                    <option value="hscl-25" {{ ($lastTest ?? '') === 'hscl-25' ? 'selected' : '' }}>HSCL-25</option>
                                    <option value="htq" {{ ($lastTest ?? '') === 'htq' ? 'selected' : '' }}>HTQ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tableJenisKelamin">Jenis Kelamin</label>
                                <select class="form-control" id="tableJenisKelamin" name="jenis_kelamin">
                                    <option value="">Semua</option>
                                    <option value="laki" {{ ($jenisKelamin ?? '') === 'laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ ($jenisKelamin ?? '') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tableGhqStatus">Status GHQ</label>
                                <select class="form-control" id="tableGhqStatus" name="ghq_status">
                                    <option value="">Semua</option>
                                    <option value="normal" {{ ($ghqStatus ?? '') === 'normal' ? 'selected' : '' }}>Normal (&le;5)</option>
                                    <option value="perhatian" {{ ($ghqStatus ?? '') === 'perhatian' ? 'selected' : '' }}>Perlu Perhatian (6-9)</option>
                                    <option value="tindak_lanjut" {{ ($ghqStatus ?? '') === 'tindak_lanjut' ? 'selected' : '' }}>Perlu Tindak Lanjut (&ge;10)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        @if (request('start_date') || request('end_date') || request('search') || request('last_test') || request('jenis_kelamin') || request('ghq_status'))
                            <a href="{{ route('admin.rekap', ['tab' => 'table']) }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        @endif
                        <a href="{{ route('admin.rekap.download', request()->only(['start_date', 'end_date', 'search', 'last_test', 'jenis_kelamin', 'ghq_status'])) }}" class="btn btn-success" id="downloadCsvBtn">
                            <i class="fas fa-download"></i> Download CSV
                        </a>
                    </div>
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-bordered mt-3" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Nama</th>
                            <th style="width: 10%">Waktu Tes</th>
                            <th style="width: 5%">Share Data</th>
                            <th style="width: 15%">GHQ</th>
                            <th style="width: 15%">DASS21</th>
                            <th style="width: 15%">HSCL25</th>
                            <th style="width: 15%">HTQ</th>
                            <th style="width: 5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hasils as $hasil)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $hasil->user->name }}</td>
                                <td>{{ $hasil->created_at->format('l, d F Y') }}</td>
                                <td>
                                    @if ($hasil->agreed_to_share_data)
                                        <span class="badge badge-success">Ya</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak</span>
                                    @endif
                                </td>
                                <td>
                                    Nilai : {{ $hasil->ghq_total }}
                                    <br>
                                    @if ($hasil->ghq_total <= 5)
                                        <span class="badge badge-success">Normal</span>
                                        <br><br>
                                        <p>Rekomendasi : Psikoedukasi</p>
                                    @elseif ($hasil->ghq_total < 10)
                                        <span class="badge badge-warning">Perlu Perhatian</span>
                                        <br><br>
                                        <p>Rekomendasi : Psikoedukasi</p>
                                    @else
                                        <span class="badge badge-danger">Perlu Tindak Lanjut</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($hasil->last_test != 'ghq12')
                                        Skor D: {{ $hasil->dass21_depresi }}
                                        <br>
                                        @if ($hasil->dass21_depresi < 10)
                                            <span class="badge badge-success">Normal</span>
                                        @elseif ($hasil->dass21_depresi < 14)
                                            <span class="badge badge-success">Ringan</span>
                                        @elseif ($hasil->dass21_depresi < 21)
                                            <span class="badge badge-warning">Sedang</span>
                                        @elseif ($hasil->dass21_depresi < 28)
                                            <span class="badge badge-danger">Parah</span>
                                        @else
                                            <span class="badge badge-danger">Sangat Parah</span>
                                        @endif

                                        <br>
                                        Skor A: {{ $hasil->dass21_kecemasan }}
                                        <br>
                                        @if ($hasil->dass21_kecemasan < 8)
                                            <span class="badge badge-success">Normal</span>
                                        @elseif ($hasil->dass21_kecemasan < 10)
                                            <span class="badge badge-success">Ringan</span>
                                        @elseif ($hasil->dass21_kecemasan < 15)
                                            <span class="badge badge-warning">Sedang</span>
                                        @elseif ($hasil->dass21_kecemasan < 20)
                                            <span class="badge badge-danger">Parah</span>
                                        @else
                                            <span class="badge badge-danger">Sangat Parah</span>
                                        @endif
                                        <br>
                                        Skor S: {{ $hasil->dass21_stress }}
                                        <br>
                                        @if ($hasil->dass21_kecemasan < 15)
                                            <span class="badge badge-success">Normal</span>
                                        @elseif ($hasil->dass21_kecemasan < 19)
                                            <span class="badge badge-success">Ringan</span>
                                        @elseif ($hasil->dass21_kecemasan < 26)
                                            <span class="badge badge-warning">Sedang</span>
                                        @elseif ($hasil->dass21_kecemasan < 34)
                                            <span class="badge badge-danger">Parah</span>
                                        @else
                                            <span class="badge badge-danger">Sangat Parah</span>
                                        @endif
                                    @else
                                        Tidak Dikerjakan
                                    @endif
                                </td>
                                <td>
                                    @if ($hasil->last_test != 'ghq12' && $hasil->last_test != 'dass-21')
                                        Depresi: {{ $hasil->hscl25_depresiDSM4 }}
                                        <br>
                                        @if ($hasil->hscl25_depresiDSM4 < 1.75)
                                            <span class="badge badge-success">Normal</span>
                                        @else
                                            <span class="badge badge-danger">Tinggi</span>
                                        @endif

                                        <br>
                                        Kecemasan: {{ $hasil->hscl25_kecemasan }}
                                        <br>
                                        @if ($hasil->hscl25_kecemasan < 1.75)
                                            <span class="badge badge-success">Normal</span>
                                        @else
                                            <span class="badge badge-danger">Tinggi</span>
                                        @endif
                                        <br>
                                        Total: {{ $hasil->hscl25_total }}
                                        <br>
                                        @if ($hasil->hscl25_total < 1.75)
                                            <span class="badge badge-success">Normal</span>
                                        @else
                                            <span class="badge badge-danger">Tinggi</span>
                                        @endif
                                        <br><br>
                                        @if ($hasil->hscl25_depresiDSM4 < 1.75 && $hasil->hscl25_kecemasan < 1.75 && $hasil->hscl25_total < 1.75)
                                            <p>Rekomendasi : Psikoedukasi</p>
                                        @else
                                            <p>Rekomendasi : </p>
                                        @endif
                                    @else
                                        Tidak Dikerjakan
                                    @endif
                                </td>
                                <td>
                                    @if ($hasil->last_test != 'ghq12' && $hasil->last_test != 'dass-21' && $hasil->last_test != 'hscl-25')
                                        Depresi: {{ $hasil->htq_depresiDSM4 }}
                                        <br>
                                        @if ($hasil->htq_depresiDSM4 < 2.5)
                                            <span class="badge badge-success">Normal</span>
                                        @else
                                            <span class="badge badge-danger">Tinggi</span>
                                        @endif

                                        <br>
                                        Total: {{ $hasil->htq_total }}
                                        <br>
                                        @if ($hasil->htq_total < 2.5)
                                            <span class="badge badge-success">Normal</span>
                                        @else
                                            <span class="badge badge-danger">Tinggi</span>
                                        @endif
                                        @if ($hasil->htq_depresiDSM4 < 1.75 && $hasil->hscl25_kecemasan < 1.75 && $hasil->hscl25_total < 1.75)
                                            <p>Rekomendasi : Psikoedukasi</p>
                                        @else
                                            <p>Rekomendasi : </p>
                                        @endif
                                    @else
                                        Tidak Dikerjakan
                                    @endif
                                </td>
                                <td>
                                    <a target="_blank" href="{{ route('hasil.show', ['hasil' => $hasil]) }}">Lihat</a>
                                    <a target="_blank"
                                        href="{{ route('hasil.download', ['hasil' => $hasil]) }}">Unduh</a>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Toast notif --}}
    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right:0 ; top: 0;">
        <div id="liveToastBerhasil" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true"
            data-delay="10000">
            <div class="toast-header">
                <strong class="mr-auto">Berhasil</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Data berhasil diperbarui.
            </div>
        </div>
    </div>
    <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right:0 ; top: 0;">
        <div id="liveToastError" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true"
            data-delay="10000">
            <div class="toast-header">
                <strong class="mr-auto">Gagal</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Maaf, terjadi kesalahan saat memperbarui data. Silakan refresh halaman.
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let ghqChart, dass21Chart, hscl25Chart, htqChart = null;
            let genderChart, usiaChart, masaKerjaChart, unitKerjaChart = null;

            // ================== CHART TES ==================

            // function to draw ghq chart
            function drawGhqChart(response) {
                if (ghqChart) {
                    ghqChart.destroy();
                }

                const ctx = document.getElementById('ghqChart').getContext('2d');
                ghqChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Sehat (<10)', 'Perlu Perhatian Khusus (≥10)'],
                        datasets: [{
                            data: [
                                response.data.ghq_healthy,
                                response.data.ghq_need_attention
                            ],
                            backgroundColor: [
                                'rgba(34, 197, 94, 0.8)', // Green for healthy
                                'rgba(239, 68, 68, 0.8)' // Red for needs attention
                            ],

                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribusi Komponen GHQ-12',
                                font: {
                                    size: 16
                                }
                            },
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / response.data.jumlah_ghq) * 100).toFixed(1) : 0;
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // function to draw DASS chart
            function drawDassChart(response) {
                if (dass21Chart) {
                    dass21Chart.destroy();
                }

                const ctx = document.getElementById('dass21Chart').getContext('2d');
                dass21Chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            'Gejala Depresi (D ≥ 21)',
                            'Gejala Cemas (A ≥ 20)',
                            'Gejala Stress (S ≥ 34)'
                        ],
                        datasets: [{
                            data: [
                                response.data.dass21_depresi,
                                response.data.dass21_cemas,
                                response.data.dass21_stress,
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(218, 114, 138, 0.8)',
                                'rgba(255, 205, 86, 0.8)'
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribusi Komponen DASS-21',
                                font: {
                                    size: 16
                                }
                            },
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / response.data.jumlah_dass21) * 100).toFixed(1) : 0;
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // function draw hscl chart
            function drawHsclChart(response) {
                if (hscl25Chart) {
                    hscl25Chart.destroy();
                }

                const ctx = document.getElementById('hscl25Chart').getContext('2d');
                hscl25Chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Gangguan Mixed', 'Gangguan Cemas', 'Gangguan Depresi'],
                        datasets: [{
                            data: [
                                response.data.hscl25_mixed_anxiety_depression,
                                response.data.hscl25_depresi,
                                response.data.hscl25_kecemasan,
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(218, 114, 138, 0.8)',
                                'rgba(255, 205, 86, 0.8)'
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribusi Komponen HSCL-25',
                                font: {
                                    size: 16
                                }
                            },
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / response.data.jumlah_hscl25) * 100).toFixed(1) : 0;
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // function draw Htq chart
            function drawHtqChart(response) {
                if (htqChart) {
                    htqChart.destroy();
                }

                const ctx = document.getElementById('htqChart').getContext('2d');
                htqChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Gangguan Depresi Trauma', 'Gangguan Cemas Trauma'],
                        datasets: [{
                            label: 'Jumlah Responden',
                            data: [
                                response.data.htq_depresi_trauma,
                                response.data.htq_cemas_trauma,
                            ],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(218, 114, 138, 0.8)',
                            ],

                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribusi Komponen HSCL25 + HTQ',
                                font: {
                                    size: 16
                                }
                            },
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / response.data.jumlah_htq) * 100).toFixed(1) : 0;
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                        }
                    }
                });
            }

            // function to hydrate dashboard data
            function drawDashboard(response) {
                $('#jumlahResponden').text(response.data.jumlah_responden);
                $('#jumlahTes').text(response.data.jumlah_tes);
                $('#jumlahGHQ').text(response.data.jumlah_ghq);
                $('#jumlahDASS21').text(response.data.jumlah_dass21);
                $('#jumlahHSCL25').text(response.data.jumlah_hscl25);
                $('#jumlahHTQ').text(response.data.jumlah_htq);
            }

            // function to fetch data from database (tes)
            function fetchData(start_date = null, end_date = null) {
                $.ajax({
                    url: "{{ route('admin.rekap.bar-chart-data') }}",
                    type: 'GET',
                    data: start_date && end_date ? {
                        start_date,
                        end_date
                    } : {},
                    success: function(response) {
                        drawGhqChart(response);
                        drawDassChart(response);
                        drawHsclChart(response);
                        drawHtqChart(response);
                        drawDashboard(response);
                        $('#liveToastBerhasil').toast('show');
                    },
                    error: function(error) {
                        $('#liveToastError').toast('show');
                    }
                });
            }

            // ================== DEMOGRAFI ==================

            function drawDemografiCharts(data) {
                const usia = data.usia || [];
                const masaKerja = data.masa_kerja || [];
                const jenisKelamin = data.jenis_kelamin || [];
                const unitKerja = data.unit_kerja || [];

                // --- Jenis Kelamin ---
                let totalLaki = 0;
                let totalPerempuan = 0;
                let totalLain = 0;

                jenisKelamin.forEach(jk => {
                    if (!jk) return;
                    const v = jk.toString().toLowerCase();
                    if (v.includes('laki')) {
                        totalLaki++;
                    } else if (v.includes('perempuan')) {
                        totalPerempuan++;
                    } else {
                        totalLain++;
                    }
                });

                $('#totalLaki').text(totalLaki);
                $('#totalPerempuan').text(totalPerempuan);

                if (genderChart) {
                    genderChart.destroy();
                }

                const genderCtx = document.getElementById('genderChart').getContext('2d');
                genderChart = new Chart(genderCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Laki-laki', 'Perempuan', 'Lain / Tidak mengisi'],
                        datasets: [{
                            data: [totalLaki, totalPerempuan, totalLain],
                            backgroundColor: [
                                'rgba(218, 114, 138, 0.8)',
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(156, 163, 175, 0.8)'
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribusi Jenis Kelamin',
                                font: { size: 16 }
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });

                // --- Usia (Kelompok non-overlap) ---
                const usiaBuckets = {
                    '18-24': 0,
                    '25-34': 0,
                    '35-44': 0,
                    '45-54': 0,
                    '55+': 0,
                };

                usia.forEach(u => {
                    const val = parseInt(u, 10);
                    if (isNaN(val) || val < 18) return;
                    if (val >= 18 && val <= 24) usiaBuckets['18-24']++;
                    else if (val <= 34) usiaBuckets['25-34']++;
                    else if (val <= 44) usiaBuckets['35-44']++;
                    else if (val <= 54) usiaBuckets['45-54']++;
                    else usiaBuckets['55+']++;
                });

                if (usiaChart) {
                    usiaChart.destroy();
                }

                const usiaCtx = document.getElementById('usiaChart').getContext('2d');
                usiaChart = new Chart(usiaCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(usiaBuckets),
                        datasets: [{
                            data: Object.values(usiaBuckets),
                            backgroundColor: [
                                'rgba(218, 114, 138, 0.8)',
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(234, 179, 8, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(148, 163, 184, 0.8)',
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribusi Usia',
                                font: { size: 16 }
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });

                // --- Angkatan (per tahun) ---
                const mkBuckets = {};
                const mkColors = [
                    'rgba(218, 114, 138, 0.8)',
                    'rgba(200, 130, 150, 0.8)',
                    'rgba(230, 150, 170, 0.8)',
                    'rgba(190, 120, 140, 0.8)',
                    'rgba(240, 170, 185, 0.8)',
                    'rgba(180, 110, 130, 0.8)',
                    'rgba(250, 160, 175, 0.8)',
                    'rgba(210, 140, 155, 0.8)',
                ];

                masaKerja.forEach(mk => {
                    const val = parseInt(mk, 10);
                    if (isNaN(val) || val < 0) return;
                    const label = String(val);
                    mkBuckets[label] = (mkBuckets[label] || 0) + 1;
                });

                const sortedLabels = Object.keys(mkBuckets).sort((a, b) => a - b);
                const sortedData = sortedLabels.map(k => mkBuckets[k]);
                const sortedColors = sortedLabels.map((_, i) => mkColors[i % mkColors.length]);

                if (masaKerjaChart) {
                    masaKerjaChart.destroy();
                }

                const mkCtx = document.getElementById('masaKerjaChart').getContext('2d');
                masaKerjaChart = new Chart(mkCtx, {
                    type: 'bar',
                    data: {
                        labels: sortedLabels,
                        datasets: [{
                            data: sortedData,
                            backgroundColor: sortedColors,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribusi Angkatan',
                                font: { size: 16 }
                            },
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });

                // --- Unit Kerja ---
                const unitList = [
                    'Kantor Pusat',
                    'Fakultas Teknik',
                    'Fakultas Peternakan dan Pertanian',
                    'Fakultas Perikanan dan Ilmu Kelautan',
                    'Fakultas Psikologi',
                    'Fakultas Sain dan Matematika',
                    'Fakultas Kedokteran',
                    'Fakultas Kesehatan Masyarakat',
                    'Fakultas Ekonomika dan Bisnis',
                    'Fakultas Hukum',
                    'Fakultas Ilmu Sosial dan Ilmu Politik',
                    'Fakultas Ilmu Budaya',
                    'Sekolah Vokasi',
                    'Sekolah Pasca Sarjana',
                    'PSDKU',
                ];

                const unitBuckets = {};
                unitList.forEach(u => unitBuckets[u] = 0);
                unitBuckets['Lainnya'] = 0;

                unitKerja.forEach(uk => {
                    if (!uk) return;
                    if (unitBuckets.hasOwnProperty(uk)) {
                        unitBuckets[uk]++;
                    } else {
                        unitBuckets['Lainnya']++;
                    }
                });

                if (unitKerjaChart) {
                    unitKerjaChart.destroy();
                }

                const unitCtx = document.getElementById('unitKerjaChart').getContext('2d');
                unitKerjaChart = new Chart(unitCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(unitBuckets),
                        datasets: [{
                            data: Object.values(unitBuckets),
                            backgroundColor: [
                                'rgba(59,130,246,0.8)',
                                'rgba(34,197,94,0.8)',
                                'rgba(234,179,8,0.8)',
                                'rgba(239,68,68,0.8)',
                                'rgba(230,150,170,0.8)',
                                'rgba(190,120,140,0.8)',
                                'rgba(16,185,129,0.8)',
                                'rgba(250,204,21,0.8)',
                                'rgba(248,113,113,0.8)',
                                'rgba(96,165,250,0.8)',
                                'rgba(74,222,128,0.8)',
                                'rgba(251,146,60,0.8)',
                                'rgba(240,170,185,0.8)',
                                'rgba(220,160,175,0.8)',
                                'rgba(148,163,184,0.8)',
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Distribusi Unit Kerja',
                                font: { size: 16 }
                            },
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            },
                            x: {
                                ticks: {
                                    maxRotation: 60,
                                    minRotation: 30,
                                    autoSkip: false,
                                }
                            }
                        }
                    }
                });
            }

            function fetchDemografi(start_date = null, end_date = null) {
                $.ajax({
                    url: "{{ route('admin.rekap.demografi') }}",
                    type: 'GET',
                    data: start_date && end_date ? {
                        start_date: start_date,
                        end_date: end_date
                    } : {},
                    success: function(response) {
                        if (response && response.success) {
                            drawDemografiCharts(response.data);
                        }
                    },
                    error: function() {
                    }
                });
            }

            // ================== INIT ==================

            fetchData();
            fetchDemografi();

            $('#filterForm').submit(function(e) {
                e.preventDefault();
                const startDate = $('#inputStartDate').val();
                const endDate = $('#inputEndDate').val();
                fetchData(startDate, endDate);
                fetchDemografi(startDate, endDate);
            });

        });
    </script>
@endsection
