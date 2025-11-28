<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Field yang wajib diisi
            $requiredFields = [
                'name',
                'username', //NIP
                'jenis_kelamin',
                'usia',
                'masa_kerja',
                'unit_kerja',
                'email',
                'alamat',
            ];

            // Cek apakah ada yang kosong
            foreach ($requiredFields as $field) {
                if (empty($user->$field)) {
                    session()->put('incomplete_profile', true);
                    break;
                }
            }
        }

        return $next($request);
    }
}
