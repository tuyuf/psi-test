<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'username'        => ['required', 'string', 'unique:users,username'],
            'jenis_kelamin'   => ['required', 'string', 'max:255'],
            'usia'            => ['nullable', 'integer', 'between:0,99'],
            'masa_kerja'      => ['nullable', 'integer', 'between:0,99'],
            'unit_kerja'      => ['nullable', 'string', 'max:255'],
            'alamat'          => ['nullable', 'string', 'max:255'],
            'telepon'         => ['nullable', 'numeric', 'digits_between:8,15'],
            'health_history'  => ['nullable', 'string', 'max:1000'],
            'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'ends_with:undip.ac.id'],
            'alternate_email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,alternate_email'],
            'role'            => ['required', 'in:1,2'],
            'password'        => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name'            => $request->name,
            'username'        => $request->username,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'usia'            => $request->usia,
            'masa_kerja'      => $request->masa_kerja,
            'unit_kerja'      => $request->unit_kerja,
            'alamat'          => $request->alamat,
            'telepon'         => $request->telepon,
            'health_history' => $request->health_history,
            'email'           => $request->email,
            'alternate_email' => $request->alternate_email,
            'level'           => $request->role, // 1=user, 2=admin
            'password'        => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'User ' . $user->name . ' berhasil dibuat');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $userId = $user->id;

        $rules = [
            'name'            => ['required', 'string', 'max:255'],
            'username'        => ['required', 'string', 'unique:users,username,' . $userId],
            'jenis_kelamin'   => ['required', 'string', 'max:255'],
            'usia'            => ['nullable', 'integer', 'between:0,99'],
            'masa_kerja'      => ['nullable', 'integer', 'between:0,99'],
            'unit_kerja'      => ['nullable', 'string', 'max:255'],
            'alamat'          => ['nullable', 'string', 'max:255'],
            'telepon'         => ['nullable', 'numeric', 'digits_between:8,15'],
            'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', 'ends_with:undip.ac.id', 'unique:users,email,' . $userId],
            'alternate_email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,alternate_email,' . $userId],
            'role'            => ['required', 'in:1,2'],
            'password'        => ['nullable', 'confirmed', Password::defaults()],
        ];

        $request->validate($rules);

        $data = $request->only([
            'name', 'username', 'jenis_kelamin', 'usia', 'masa_kerja',
            'unit_kerja', 'alamat', 'telepon', 'email', 'alternate_email'
        ]);

        $data['level'] = $request->role; // role harus tetap bisa diedit

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate');
    }
}
