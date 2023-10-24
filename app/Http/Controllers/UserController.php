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

    protected static $levelLists = [
        1 => 'admin',
        2 => 'owner',
        3 => 'pekerja'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.pengguna', [
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
                'create_name' => 'required|min:6|max:50',
                'create_username' => 'required|regex:/^\S*$/u|lowercase',
                'create_password' => [
                    'required',
                    Password::min(8)
                ],
                'create_level' => [
                    'required',
                    Rule::in(['admin', 'owner', 'pekerja']),
                ],
            ],
            [
                // Name custom message for validation
                'create_name.required' => 'Nama Wajib Diisi !',
                'create_name.min' => 'Karakter Pada Nama Harus Diantara 6 - 50 Karakter !',
                'create_name.max' => 'Karakter Pada Nama Harus Diantara 6 - 50 Karakter !',

                // Username custom message for validation
                'create_username.required' => 'Username Wajib Diisi !',
                'create_username.regex' => 'Username Tidak Boleh Diisi Karakter Spasi !',
                'create_username.lowercase' => 'Username Harus Menggunakan Huruf Kecil !',

                // Password custom message for validation
                'create_password.required' => 'Password Wajib Diisi !',
                'create_password.min' => 'Password Minimal 8 Karakter !',

                // Level custom message for validation
                'create_level.required' => 'Level Wajib Diisi !',
                'create_level.in' => 'Pilihan Pada Level Harus Admin / Owner / Pekerja !',
            ],
        );

        try {
            // Simpan data user ke database
            User::create([
                'name'      => $validatedData['create_name'],
                'username'  => $validatedData['create_username'],
                'password'  => HASH::make($validatedData['create_password']),
                'level'     => $validatedData['create_level'],
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
                'edit_name' => 'required|min:6|max:50',
                'edit_username' => 'required|regex:/^\S*$/u|lowercase',
                'edit_password' => [
                    'nullable',
                    'sometimes',
                    Password::min(8)
                ],
                'edit_level' => [
                    'required',
                    Rule::in(['admin', 'owner', 'pekerja']),
                ],
                'edit_status' => [
                    'required',
                    Rule::in(['aktif', 'nonaktif']),
                ],
            ],
            [
                // Name custom message for validation
                'edit_name.required' => 'Nama Wajib Diisi !',
                'edit_name.min' => 'Karakter Pada Nama Harus Diantara 6 - 50 Karakter !',
                'edit_name.max' => 'Karakter Pada Nama Harus Diantara 6 - 50 Karakter !',

                // Username custom message for validation
                'edit_username.required' => 'Username Wajib Diisi !',
                'edit_username.regex' => 'Username Tidak Boleh Diisi Karakter Spasi !',
                'edit_username.lowercase' => 'Username Harus Menggunakan Huruf Kecil !',

                // Password custom message for validation
                'edit_password.min' => 'Password Minimal 8 Karakter !',

                // Level custom message for validation
                'edit_level.required' => 'Level Wajib Diisi !',
                'edit_level.in' => 'Pilihan Pada Level Harus Admin / Owner / Pekerja !',

                // Status custom message for validation
                'edit_level.required' => 'Status Wajib Diisi !',
                'edit_level.in' => 'Pilihan Pada Status Harus Aktif / Non-Aktif !',
            ],
        );

        try {
            // Simpan data user ke database
            $update = [
                'name'      => $validatedData['edit_name'],
                'username'     => $validatedData['edit_username'],
                'level'      => $validatedData['edit_level'],
                'status'      => $validatedData['edit_status'],
            ];

            if ($request->edit_password) {
                $update['password'] = HASH::make($validatedData['edit_password']);
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

    public static function levelToArray()
    {
        $lists = [];

        foreach (static::$levelLists as $key => $value) {
            $lists[$key] = $value;
        }

        return $lists;
    }
}
