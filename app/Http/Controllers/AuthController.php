<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'NIP atau Password salah.')->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register()
    {
        return view('auth.register');
    }

    // 🔹 tampilkan form ubah password
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    // 🔹 proses ubah password
    public function changePassword(Request $request)
{
    $request->validate([
        'username' => ['required', 'string'],         // NIP
        'email' => ['required', 'email'],            // Email UNDIP
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    // Cari user berdasarkan NIP + Email UNDIP
    $user = User::where('username', $request->username)
                ->where('email', $request->email)
                ->first();

    if (!$user) {
        return back()->withErrors([
            'username' => 'NIP atau Email UNDIP tidak sesuai dengan data kami.',
        ])->withInput();
    }

    // Update password
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
}

}
