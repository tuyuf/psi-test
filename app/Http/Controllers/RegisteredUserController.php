<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required','string', 'unique:'.User::class], //NIP
        'jenis_kelamin' => ['required', 'string', 'max:255'],
        'usia' => ['required', 'integer', 'min:15', 'max:99'],
        'masa_kerja' => ['required', 'integer', 'min:0'],
        'unit_kerja' => ['required', 'string', 'max:100'],
        'alamat' => ['required', 'string', 'max:255'],
        'telepon' => ['nullable', 'numeric', 'max_digits:20'],
        'health_history' => ['nullable', 'string', 'max:1000'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class, 'ends_with:undip.ac.id'],
        'password' => ['required', 'confirmed', Password::defaults()],
        'alternate_email' => ['nullable', 'lowercase', 'string', 'email', 'max:255'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'jenis_kelamin' => $request->jenis_kelamin,
        'usia' => $request->usia,
        'masa_kerja' => $request->masa_kerja,
        'unit_kerja' => $request->unit_kerja,
        'alamat' => $request->alamat,
        'telepon' => $request->telepon,
        'health_history' => $request->health_history,
        'email' => $request->email,
        'level' => 2,
        'password' => Hash::make($request->password),
        'alternate_email' => $request->alternate_email
    ]);

        return redirect()->route('login');
    }
}
