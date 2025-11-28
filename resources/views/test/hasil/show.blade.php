<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Screening Kesehatan Mental</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .subheader {
            text-align: center;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .line {
            border-top: 1px solid black;
            margin-bottom: 10px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .info-table td {
            padding: 3px;
        }

        .info-table td:first-child {
            width: 20%;
        }

        .info-table td:nth-child(2) {
            width: 30%;
        }

        .info-table td:nth-child(3) {
            width: 20%;
        }

        .info-table td:nth-child(4) {
            width: 30%;
        }

        .assessment-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .assessment-table th,
        .assessment-table td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        .assessment-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            padding-left: 5px;
            background-color: #f9f9f9;
            border-top: 1px solid black;
        }

        .indent {
            padding-left: 15px;
        }
    </style>
</head>

<body>

   <div class="container">
    <div class="header">
        LAPORAN HASIL SCREENING KESEHATAN MENTAL<br>
        TIM FAKULTAS PSIKOLOGI UNIVERSITAS DIPONEGORO
    </div>

    <div class="subheader">
        Jl. Prof. Mr. Sunario, Tembalang, Semarang Telp. (024) 7460051 &nbsp;&nbsp;&nbsp;&nbsp; Penanggung Jawab: Psikolog (...)
    </div>

    <div class="line"></div>

    <table class="info-table">
        <tr>
            <td>NO. REG</td>
            <td>: {{ $hasil->user->nomor_registrasi ?? '-' }}</td>
            <td>NAMA</td>
            <td>: {{ $hasil->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>ALAMAT</td>
            <td>: {{ $hasil->user->alamat ?? '-' }}</td>
            <td>TANGGAL REG</td>
            <td>: {{ $hasil->created_at ? $hasil->created_at->format('d-m-Y') : '-' }}</td>
        </tr>
        <tr>
            <td>JENIS KELAMIN</td>
            <td>: {{ $hasil->user->jenis_kelamin ?? '-' }}</td>
            <td>TGL. LAHIR / USIA</td>
            <td>: {{ $hasil->user->usia ? $hasil->user->usia . ' Tahun' : '-' }}</td>
        </tr>
        <tr>
            <td>NO. TLP. / HP</td>
            <td>: {{ $hasil->user->telepon ?? '-' }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>

        <table class="assessment-table">
            <tr>
                <th>JENIS ASESMEN</th>
                <th>HASIL (RAW SCORE)</th>
                <th>NILAI RUJUKAN</th>
                <th>METODE</th>
            </tr>
            <tr>
                <td><strong>KONDISI KESEHATAN MENTAL UMUM</strong></td>
                <td>{{ $hasil->ghq_total }}</td>
                @if ($hasil->ghqAnswers?->keterangan)
                <td>{{ $hasil->ghqAnswers->keterangan == 'sehat' ? 'Normal' : 'Tinggi' }}</td>
                @else
                <td></td>
                @endif
                <td><strong>GHQ</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="section-title">GEJALA PERMASALAHAN KESEHATAN MENTAL</td>
            </tr>
            <tr>
                <td class="indent">Gejala Distress</td>
                @if ($hasil->dass21Answers)
                    <td>{{ $hasil->dass21_stress }}</td>
                    <td>{{ $hasil->dass21Answers->keterangan_stress ?? '' }}</td>
                @else
                    <td>Tidak Dikerjakan</td>
                    <td></td>
                @endif
                <td><strong>DASS-21</strong></td>
            </tr>
            <tr>
                <td class="indent">Gejala Kecemasan (Anxiety)</td>
                @if ($hasil->dass21Answers)
                    <td>{{ $hasil->dass21_kecemasan }}</td>
                    <td>{{ $hasil->dass21Answers->keterangan_kecemasan ?? '' }}</td>
                @else
                    <td>Tidak Dikerjakan</td>
                    <td></td>
                @endif
                <td><strong>DASS-21</strong></td>
            </tr>
            <tr>
                <td class="indent">Gejala Emosional (Depresi)</td>
                @if ($hasil->dass21Answers)
                    <td>{{ $hasil->dass21_depresi }}</td>
                    <td>{{ $hasil->dass21Answers->keterangan_depresi ?? '' }}</td>
                @else
                    <td>Tidak Dikerjakan</td>
                    <td></td>
                @endif
                <td><strong>DASS-21</strong></td>
            </tr>
            <tr>
                <td colspan="4" class="section-title">SCREENING AWAL GANGGUAN KEJIWAAN</td>
            </tr>
            <tr>
                <td class="indent">Gangguan Cemas</td>
                @if ($hasil->hscl25Answers)
                    <td>{{ $hasil->hscl25_kecemasan ?? '' }}</td>
                    <td>{{ $hasil->hscl25_kecemasan < 1.75 ? 'Normal' : 'Tinggi' }}</td>
                @else
                    <td>Tidak Dikerjakan</td>
                    <td></td>
                @endif
                <td><strong>HSCL-25</strong></td>
            </tr>
            <tr>
                <td class="indent">Gangguan Mood Depresi</td>
                @if ($hasil->hscl25Answers)
                    <td>{{ $hasil->hscl25_depresiDSM4 }}</td>
                    <td>{{ $hasil->hscl25_depresiDSM4 < 1.75 ? 'Normal' : 'Tinggi' }}</td>
                @else
                    <td>Tidak Dikerjakan</td>
                    <td></td>
                @endif
                <td><strong>HSCL-25</strong></td>
            </tr>
            <tr>
                <td class="indent">Mixed Anxiety and Depression Disorder</td>
                @if ($hasil->hscl25Answers)
                <td>{{ $hasil->hscl25_total }}</td>
                <td>{{ $hasil->hscl25_total < 1.75 ? 'Normal' : 'Tinggi' }}</td>
                @else
                    <td>Tidak Dikerjakan</td>
                    <td></td>
                @endif
                <td><strong>HSCL-25</strong></td>
            </tr>
            <tr>
                <td class="indent">Gangguan Stres Pasca Trauma (PTSD)</td>
                @if ($hasil->htqAnswers)
                <td>
                    <p>Skor D :{{ $hasil->htq_depresiDSM4 }}</p>
                    <p>Skor Total :{{ $hasil->htq_total }}</p>
                </td>
                <td>{{ $hasil->htq_total < 2.5 && $hasil->htq_depresiDSM4 < 2.5 ? 'Normal' : 'Tinggi' }}</td>
                @else
                    <td>Tidak Dikerjakan</td>
                    <td></td>
                @endif
                <td><strong>HTQ</strong></td>
            </tr>
        </table>
    </div>

</body>

</html>
