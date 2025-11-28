<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRekapController extends Controller
{
    /**
     * Halaman utama rekap (tab TABEL).
     */
    public function index()
    {
        $hasils = Hasil::where('status_pengerjaan', 'selesai')
            ->where('agreed_to_share_data', true)
            ->where('last_test', '!=', 'ghq12')
            ->get();

        return view('admin.rekap.index', compact('hasils'));
    }


    /**
     * Data untuk Card & Chart GHQ / DASS / HSCL / HTQ (AJAX dashboard).
     */
    public function getBarChartData(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;

        // Filter untuk INNER dan OUTER query
        $innerDate = '';
        $outerDate = '';

        if ($start && $end) {
            $innerDate = " AND hasils.created_at BETWEEN '{$start}' AND '{$end}'";
            $outerDate = " WHERE h.created_at BETWEEN '{$start}' AND '{$end}'";
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
                      {$innerDate}
                    GROUP BY hasils.user_id
                ) h2
                    ON h1.user_id = h2.user_id
                   AND CONCAT(h1.created_at,'-',h1.id) = h2.latest_test
            ) h
            {$outerDate};
        ";

        $data = DB::select($sql)[0];

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }


    /**
     * Data Demografi (usia, jenis kelamin, unit, masa kerja).
     */
    public function getDemografi(Request $request)
    {
        $users = User::where('level', '!=', 1)
            ->whereHas('hasil', function ($q) {
                $q->where('status_pengerjaan', 'selesai')
                  ->where('agreed_to_share_data', 1)
                  ->where('last_test', '!=', 'ghq12');
            })
            ->get(['usia', 'jenis_kelamin', 'unit_kerja', 'masa_kerja']);

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
