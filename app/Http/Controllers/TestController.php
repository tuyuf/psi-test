<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        // Load hasil dengan relasi user supaya alamat & telepon bisa dipakai di view/PDF
        $hasils = auth()->user()
            ->hasil()
            ->with('user')
            ->where('status_pengerjaan', 'selesai')
            ->orderByDesc('created_at')
            ->get();

        $latestHasilId = auth()->user()->latestHasil->id ?? null;

        return view('test.hasil.index', compact('hasils', 'latestHasilId'));
    }

    public function show(Hasil $hasil)
    {
        $hasil->load('user', 'ghqAnswers', 'dass21Answers');
        return view('test.hasil.show', compact('hasil'));
    }

   public function download(Hasil $hasil)
{
    $mpdf = new \Mpdf\Mpdf([
        'tempDir' => storage_path('app/mpdf-temp'),
    ]);

    // Load semua relasi yang dibutuhkan
    $hasil->load([
        'user',
        'ghqAnswers',
        'dass21Answers',
        'hscl25Answers',
        'htqAnswers'
    ]);

    // Render view ke HTML
    $html = view('test.hasil.show', compact('hasil'))->render();

    // Tulis ke PDF
    $mpdf->WriteHTML($html);

    return $mpdf->OutputHttpDownload('hasil-tes-' . $hasil->created_at->format('Y-m-d') . '.pdf');
}



    public function testFinished(Hasil $hasil)
    {
        $hasil->load('user', 'ghqAnswers', 'dass21Answers');
        return view('test.finished', compact('hasil'));
    }

    public function resumeTest()
    {
        $user = auth()->user();
        $latestHasil = $user->latestHasil;

        if ($latestHasil->last_test === 'ghq12') {
            return redirect()->route('test-dass21');
        }
        if ($latestHasil->last_test === 'dass-21') {
            return redirect()->route('test-hscl25');
        }
        if ($latestHasil->last_test === 'hscl-25') {
            return redirect()->route('test-htq');
        }

        return redirect()->route('dashboard');
    }

    public function updateAgreement(Hasil $hasil, Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $hasil = Hasil::findOrFail($request->hasil_id);

                $hasil->update([
                    'agreed_to_share_data' => $request->agreed_to_share_data,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Status persetujuan berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal memperbarui status persetujuan',
                ],
                500,
            );
        }
    }
}
