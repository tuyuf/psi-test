<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AdminRekapController extends Controller
{
    /**
     * Halaman utama rekap (tab TABEL).
     */
    public function index(Request $request)
    {
        $startDate    = $request->start_date;
        $endDate      = $request->end_date;
        $search       = $request->search;
        $lastTest     = $request->last_test;
        $jenisKelamin = $request->jenis_kelamin;
        $ghqStatus    = $request->ghq_status;

        $query = Hasil::where('status_pengerjaan', 'selesai')
            ->where('agreed_to_share_data', true)
            ->with('user');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($lastTest) {
            $query->where('last_test', $lastTest);
        }

        if ($jenisKelamin) {
            $userIds = User::where('level', '!=', 1)
                ->where('jenis_kelamin', 'like', '%' . $jenisKelamin . '%')
                ->pluck('id');
            $query->whereIn('user_id', $userIds);
        }

        if ($ghqStatus) {
            if ($ghqStatus === 'normal') {
                $query->where('ghq_total', '<=', 5);
            } elseif ($ghqStatus === 'perhatian') {
                $query->whereBetween('ghq_total', [6, 9]);
            } elseif ($ghqStatus === 'tindak_lanjut') {
                $query->where('ghq_total', '>=', 10);
            }
        }

        $hasils = $query->get();

        return view('admin.rekap.index', compact(
            'hasils',
            'startDate',
            'endDate',
            'search',
            'lastTest',
            'jenisKelamin',
            'ghqStatus'
        ));
    }


    /**
     * Data untuk Card & Chart GHQ / DASS / HSCL / HTQ (AJAX dashboard).
     */
    public function getBarChartData(Request $request)
    {
        $request->validate([
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
        ]);

        $start  = $request->start_date;
        $end    = $request->end_date;
        $search = $request->search;
        $lastTest = $request->last_test;
        $jenisKelamin = $request->jenis_kelamin;
        $ghqStatus = $request->ghq_status;

        $innerCondition = '';
        $outerCondition = '';

        if ($start && $end) {
            $innerCondition .= " AND hasils.created_at BETWEEN '{$start}' AND '{$end}'";
            $outerCondition .= " AND h.created_at BETWEEN '{$start}' AND '{$end}'";
        }

        if ($search) {
            $innerCondition .= " AND users.name LIKE '%{$search}%'";
        }

        if ($lastTest) {
            $innerCondition .= " AND hasils.last_test = '{$lastTest}'";
            $outerCondition .= " AND h.last_test = '{$lastTest}'";
        }

        if ($jenisKelamin) {
            $innerCondition .= " AND users.jenis_kelamin LIKE '%{$jenisKelamin}%'";
        }

        if ($ghqStatus) {
            if ($ghqStatus === 'normal') {
                $outerCondition .= " AND h.ghq_total <= 5";
            } elseif ($ghqStatus === 'perhatian') {
                $outerCondition .= " AND h.ghq_total BETWEEN 6 AND 9";
            } elseif ($ghqStatus === 'tindak_lanjut') {
                $outerCondition .= " AND h.ghq_total >= 10";
            }
        }

        $sql = "
            SELECT
                COUNT(DISTINCT h.user_id) AS jumlah_responden,
                SUM(h.jumlah_tes) AS jumlah_tes,

                COUNT(CASE WHEN h.ghq_total IS NOT NULL THEN 1 END) AS jumlah_ghq,
                COUNT(CASE WHEN h.ghq_total < 10 THEN 1 END)        AS ghq_healthy,
                COUNT(CASE WHEN h.ghq_total >= 10 THEN 1 END)       AS ghq_need_attention,

                COUNT(CASE WHEN h.dass21_waktu IS NOT NULL THEN 1 END) AS jumlah_dass21,
                COUNT(CASE WHEN h.dass21_depresi >= 21 THEN 1 END)     AS dass21_depresi,
                COUNT(CASE WHEN h.dass21_kecemasan >= 20 THEN 1 END)   AS dass21_cemas,
                COUNT(CASE WHEN h.dass21_stress >= 34 THEN 1 END)      AS dass21_stress,

                COUNT(CASE WHEN h.hscl25_waktu IS NOT NULL THEN 1 END) AS jumlah_hscl25,
                COUNT(CASE WHEN h.hscl25_total >= 1.75 THEN 1 END)     AS hscl25_mixed_anxiety_depression,
                COUNT(CASE WHEN h.hscl25_depresiDSM4 >= 1.75 THEN 1 END) AS hscl25_depresi,
                COUNT(CASE WHEN h.hscl25_kecemasan >= 1.75 THEN 1 END)   AS hscl25_kecemasan,

                COUNT(CASE WHEN h.htq_waktu IS NOT NULL THEN 1 END) AS jumlah_htq,
                COUNT(
                    CASE WHEN h.hscl25_depresiDSM4 >= 1.75
                          AND h.htq_depresiDSM4 >  2.5
                    THEN 1 END
                ) AS htq_depresi_trauma,
                COUNT(
                    CASE WHEN h.hscl25_kecemasan >= 1.75
                          AND h.htq_total > 2.5
                    THEN 1 END
                ) AS htq_cemas_trauma

            FROM (
                SELECT
                    h2.jumlah_tes,
                    h1.*
                FROM hasils h1
                INNER JOIN (
                    SELECT
                        hasils.user_id,
                        COUNT(hasils.id) AS jumlah_tes,
                        MAX(CONCAT(hasils.created_at,'-',hasils.id)) AS latest_test
                    FROM hasils
                    LEFT JOIN users ON hasils.user_id = users.id
                    WHERE users.level != 1
                      AND hasils.status_pengerjaan = 'selesai'
                      AND hasils.agreed_to_share_data = 1
                      {$innerCondition}
                    GROUP BY hasils.user_id
                ) h2
                    ON h1.user_id = h2.user_id
                   AND CONCAT(h1.created_at,'-',h1.id) = h2.latest_test
            ) h
            WHERE 1=1
            {$outerCondition};
        ";

        $data = DB::select($sql)[0];

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }


    /**
     * Download rekap hasil sebagai CSV, filter berdasarkan tanggal jika ada.
     */
    public function download(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;

        $query = Hasil::where('status_pengerjaan', 'selesai')
            ->where('agreed_to_share_data', true)
            ->with('user');

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        $hasils = $query->get();

        $rows = [];
        $rows[] = [
            'No',
            'Nama',
            'Waktu Tes',
            'GHQ Skor',
            'GHQ Status',
            'DASS21 Depresi',
            'DASS21 Depresi Severity',
            'DASS21 Kecemasan',
            'DASS21 Kecemasan Severity',
            'DASS21 Stress',
            'DASS21 Stress Severity',
            'HSCL25 Depresi',
            'HSCL25 Depresi Status',
            'HSCL25 Kecemasan',
            'HSCL25 Kecemasan Status',
            'HSCL25 Total',
            'HSCL25 Total Status',
            'HTQ Depresi',
            'HTQ Depresi Status',
            'HTQ Total',
            'HTQ Total Status',
        ];

        foreach ($hasils as $i => $hasil) {
            $ghqStatus = $hasil->ghq_total <= 5 ? 'Normal' : ($hasil->ghq_total < 10 ? 'Perlu Perhatian' : 'Perlu Tindak Lanjut');

            $dass21_d = $hasil->dass21_depresi;
            $dass21SeverityD = $dass21_d < 10 ? 'Normal' : ($dass21_d < 14 ? 'Ringan' : ($dass21_d < 21 ? 'Sedang' : ($dass21_d < 28 ? 'Parah' : 'Sangat Parah')));

            $dass21_a = $hasil->dass21_kecemasan;
            $dass21SeverityA = $dass21_a < 8 ? 'Normal' : ($dass21_a < 10 ? 'Ringan' : ($dass21_a < 15 ? 'Sedang' : ($dass21_a < 20 ? 'Parah' : 'Sangat Parah')));

            $dass21_s = $hasil->dass21_stress;
            $dass21SeverityS = $dass21_s < 15 ? 'Normal' : ($dass21_s < 19 ? 'Ringan' : ($dass21_s < 26 ? 'Sedang' : ($dass21_s < 34 ? 'Parah' : 'Sangat Parah')));

            $hscl25DepresiStatus = $hasil->hscl25_depresiDSM4 < 1.75 ? 'Normal' : 'Tinggi';
            $hscl25CemasStatus = $hasil->hscl25_kecemasan < 1.75 ? 'Normal' : 'Tinggi';
            $hscl25TotalStatus = $hasil->hscl25_total < 1.75 ? 'Normal' : 'Tinggi';

            $htqDepresiStatus = $hasil->htq_depresiDSM4 < 2.5 ? 'Normal' : 'Tinggi';
            $htqTotalStatus = $hasil->htq_total < 2.5 ? 'Normal' : 'Tinggi';

            $rows[] = [
                $i + 1,
                $hasil->user->name ?? '',
                $hasil->created_at->format('l, d F Y'),
                $hasil->last_test == 'ghq12' ? '' : $hasil->ghq_total,
                $hasil->last_test == 'ghq12' ? '' : $ghqStatus,
                $hasil->last_test == 'ghq12' ? '' : $hasil->dass21_depresi,
                $hasil->last_test == 'ghq12' ? '' : $dass21SeverityD,
                $hasil->last_test == 'ghq12' ? '' : $hasil->dass21_kecemasan,
                $hasil->last_test == 'ghq12' ? '' : $dass21SeverityA,
                $hasil->last_test == 'ghq12' ? '' : $hasil->dass21_stress,
                $hasil->last_test == 'ghq12' ? '' : $dass21SeverityS,
                in_array($hasil->last_test, ['ghq12', 'dass-21']) ? '' : $hasil->hscl25_depresiDSM4,
                in_array($hasil->last_test, ['ghq12', 'dass-21']) ? '' : $hscl25DepresiStatus,
                in_array($hasil->last_test, ['ghq12', 'dass-21']) ? '' : $hasil->hscl25_kecemasan,
                in_array($hasil->last_test, ['ghq12', 'dass-21']) ? '' : $hscl25CemasStatus,
                in_array($hasil->last_test, ['ghq12', 'dass-21']) ? '' : $hasil->hscl25_total,
                in_array($hasil->last_test, ['ghq12', 'dass-21']) ? '' : $hscl25TotalStatus,
                in_array($hasil->last_test, ['ghq12', 'dass-21', 'hscl-25']) ? '' : $hasil->htq_depresiDSM4,
                in_array($hasil->last_test, ['ghq12', 'dass-21', 'hscl-25']) ? '' : $htqDepresiStatus,
                in_array($hasil->last_test, ['ghq12', 'dass-21', 'hscl-25']) ? '' : $hasil->htq_total,
                in_array($hasil->last_test, ['ghq12', 'dass-21', 'hscl-25']) ? '' : $htqTotalStatus,
            ];
        }

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        $filename = 'rekap-hasil-tes-' . now()->format('Y-m-d') . '.csv';

        return Response::streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function getDemografi(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $start  = $request->start_date;
        $end    = $request->end_date;
        $search = $request->search;
        $lastTest = $request->last_test;
        $jenisKelamin = $request->jenis_kelamin;
        $ghqStatus = $request->ghq_status;

        $users = User::where('level', '!=', 1)
            ->whereHas('hasil', function ($q) use ($start, $end, $search, $lastTest, $jenisKelamin, $ghqStatus) {
                $q->where('status_pengerjaan', 'selesai')
                  ->where('agreed_to_share_data', 1);

                if ($start && $end) {
                    $q->whereBetween('created_at', [$start, $end]);
                }

                if ($lastTest) {
                    $q->where('last_test', $lastTest);
                }

                if ($ghqStatus) {
                    if ($ghqStatus === 'normal') {
                        $q->where('ghq_total', '<=', 5);
                    } elseif ($ghqStatus === 'perhatian') {
                        $q->whereBetween('ghq_total', [6, 9]);
                    } elseif ($ghqStatus === 'tindak_lanjut') {
                        $q->where('ghq_total', '>=', 10);
                    }
                }
            });

        if ($search) {
            $users->where('name', 'like', '%' . $search . '%');
        }

        if ($jenisKelamin) {
            $users->where('jenis_kelamin', 'like', '%' . $jenisKelamin . '%');
        }

        $users = $users->get(['usia', 'jenis_kelamin', 'unit_kerja', 'masa_kerja']);

        return response()->json([
            'success' => true,
            'data'    => [
                'usia'          => $users->whereNotNull('usia')->pluck('usia')->values(),
                'masa_kerja'    => $users->whereNotNull('masa_kerja')->pluck('masa_kerja')->values(),
                'jenis_kelamin' => $users->whereNotNull('jenis_kelamin')->pluck('jenis_kelamin')->values(),
                'unit_kerja'    => $users->whereNotNull('unit_kerja')->pluck('unit_kerja')->values(),
            ],
        ]);
    }
}
