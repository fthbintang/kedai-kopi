<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.master.pengguna', [
            'title' => 'Data Pengguna',
            'data_pengguna' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|min:6|max:50',
                'username' => 'required|regex:/^\S*$/u|lowercase',
                'password' => [
                    'required',
                    Password::min(8)
                ],
                'level' => [
                    'required',
                    Rule::in(['admin', 'owner', 'pekerja']),
                ],
            ],
            [
                // Name custom message for validation
                'name.required' => 'Nama Wajib Diisi !',
                'name.min' => 'Karakter Pada Nama Harus Diantara 6 - 50 Karakter !',
                'name.max' => 'Karakter Pada Nama Harus Diantara 6 - 50 Karakter !',

                // Username custom message for validation
                'username.required' => 'Username Wajib Diisi !',
                'username.regex' => 'Username Tidak Boleh Diisi Karakter Spasi !',
                'username.lowercase' => 'Username Harus Menggunakan Huruf Kecil !',

                // Password custom message for validation
                'password.required' => 'Password Wajib Diisi !',
                'password.min' => 'Password Minimal 8 Karakter !',

                // Level custom message for validation
                'level.required' => 'Level Wajib Diisi !',
                'level.in' => 'Pilihan Pada Level Harus Admin / Owner / Pekerja !',
            ],
        );

        try {
            // Simpan data user ke database
            User::create([
                'name'      => $validatedData['name'],
                'username'     => $validatedData['username'],
                'password'  => HASH::make($validatedData['password']),
                'level'     => $validatedData['level'],
            ]);

            return redirect('/dashboard/pengguna')->with('success', 'Tambah User Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan user. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|min:6|max:50',
                'username' => 'required|regex:/^\S*$/u|lowercase',
                'password' => [
                    'nullable',
                    'sometimes',
                    Password::min(8)
                ],
                'level' => [
                    'required',
                    Rule::in(['admin', 'owner', 'pekerja']),
                ],
                'status' => [
                    'required',
                    Rule::in(['aktif', 'nonaktif']),
                ],
            ],
            [
                // Name custom message for validation
                'name.required' => 'Nama Wajib Diisi !',
                'name.min' => 'Karakter Pada Nama Harus Diantara 6 - 50 Karakter !',
                'name.max' => 'Karakter Pada Nama Harus Diantara 6 - 50 Karakter !',

                // Username custom message for validation
                'username.required' => 'Username Wajib Diisi !',
                'username.regex' => 'Username Tidak Boleh Diisi Karakter Spasi !',
                'username.lowercase' => 'Username Harus Menggunakan Huruf Kecil !',

                // Password custom message for validation
                'password.min' => 'Password Minimal 8 Karakter !',

                // Level custom message for validation
                'level.required' => 'Level Wajib Diisi !',
                'level.in' => 'Pilihan Pada Level Harus Admin / Owner / Pekerja !',

                // Status custom message for validation
                'level.required' => 'Status Wajib Diisi !',
                'level.in' => 'Pilihan Pada Status Harus Aktif / Non-Aktif !',
            ],
        );

        try {
            // Simpan data user ke database
            $update = [
                'name'      => $validatedData['name'],
                'username'     => $validatedData['username'],
                'level'      => $validatedData['level'],
                'status'      => $validatedData['status'],
            ];

            if ($request->password) {
                $update['password'] = HASH::make($validatedData['password']);
            }

            User::where('id', $id)
                ->update($update);

            return redirect('/dashboard/pengguna')->with('success', 'User Berhasil diubah !');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal mengubah user. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->delete();

        return redirect('/dashboard/pengguna')->with('success', 'Data Pengguna berhasil dihapus !');
    }
}
