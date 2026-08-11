<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Pastikan modal tidak muncul di halaman profil
        session()->forget('incomplete_profile');

        return view('user-profile.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Hapus session incomplete_profile supaya modal tidak muncul di halaman edit
        session()->forget('incomplete_profile');

        return view('user-profile.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $userId = $user->id;

        $rules = [
            'name'           => ['required', 'string', 'max:255'],
            'username'       => ['required', 'string', 'unique:users,username,' . $userId . ',id'], // NIP
            'jenis_kelamin'  => ['required', 'string', 'max:255'],
            'usia'           => ['required', 'integer', 'min:15', 'max:99'],
            'masa_kerja'     => ['required', 'integer', 'min:0'],
            'unit_kerja'     => ['required', 'string', 'max:100'],
            'alamat'         => ['required', 'string', 'max:255'],
            'telepon'        => ['nullable', 'numeric', 'max_digits:20'],
            'health_history' => ['nullable', 'string', 'max:1000'],
            'email'          => ['required', 'string', 'lowercase', 'email', 'max:255', 'ends_with:undip.ac.id', 'unique:users,email,' . $userId . ',id'],
            'alternate_email'=> ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users,alternate_email,' . $userId . ',id'],
            'password'       => ['nullable', 'confirmed', Password::defaults()],
        ];

        $validated = $request->validate($rules);

        // Jika password kosong → hapus dari data update
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect('profile')->with('success', 'Profil berhasil diperbarui');
    }
}
