<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGHQRequest;
use App\Models\GHQQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class GHQController extends Controller
{
    public function create()
    {
        // only allow user to access the test if they don't have any unfinished test
        if (Gate::denies('can-ghq')) {
            return redirect()->route('dashboard');
        }
        $questions = GHQQuestions::all();
        $jenis = 'ghq';
        return view('ghq.create', compact('questions','jenis'));
    }

    public function store(StoreGHQRequest $request)
    {
        $hasil = DB::transaction(function () use ($request) {
        // turn the values into integers
        $processedValues = array_map(function ($val) {
            return floor($val);
        }, $request->validated());

        // sum the values
        $summedValues = array_sum($processedValues);

        // save the values to the database
        $hasil = auth()
            ->user()
            ->hasil()
            ->create([
                'nomor_registrasi' => date('Ymd') . rand(1000, 9999),
                'total' => $summedValues,
                'status_pengerjaan' => $summedValues > 10 ? 'belum selesai' : 'selesai',
                'ghq_waktu' => now(),
                'ghq_total' => $summedValues,
                'last_test' => 'ghq12',
            ]);


        $ghq_answers = $hasil->ghqAnswers()->create(
            array_merge(
                [
                    'total' => $summedValues,
                    'keterangan' => $summedValues > 10 ? 'tidak sehat' : 'sehat',
                ],
                $processedValues,
            ),
        );

        return $hasil; // return untuk transaction callback
    });

    // Return view setelah transaksi selesai
    return redirect()->route('test-finished', compact('hasil'));
    }
}
