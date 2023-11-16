<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.profile', [
            'title' => 'Profile',
            'profile' => User::all()
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
        //
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
    public function update(Request $request, User $user, $id)
    {
        // Validasi data yang dikirim melalui formulir
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|regex:/^\S*$/u|lowercase',
            'foto' => 'image|file|max:1024',
            'password' => [
                'nullable',
                'sometimes',
                Password::min(8)
            ],
        ], [
            'name.required' => 'Nama Wajib Diisi !',
            'username.required' => 'Username Wajib Diisi !',
            'username.regex' => 'Username Tidak Boleh Diisi Karakter Spasi !',
            'username.lowercase' => 'Username Harus Menggunakan Huruf Kecil !',
            'foto.image' => 'Unggah File Gambar dengan Format JPG/JPEG/PNG/GIF',
            'foto.max' => 'Unggahan File Gambar Maksimal 1 MB',
            'password.min' => 'Password Minimal 8 Karakter !'
        ]);
    
        try {
            // Temukan pengguna berdasarkan ID
            $user = User::find($id);
    
            // Perbarui data pengguna dengan data yang dikirimkan melalui formulir
            $user->name = $validatedData['name'];
            $user->username = $validatedData['username'];
    
            if ($validatedData['password']) {
                $user->password = Hash::make($validatedData['password']);
            }
    
            // Periksa apakah ada gambar profil yang diunggah
            if ($request->hasFile('foto')) {
                $profilePicture = $request->file('foto');
    
                // Hapus gambar profil sebelumnya jika ada
                if ($user->foto) {
                    Storage::disk('public')->delete($user->foto);
                }
    
                $picturePath = $profilePicture->store('foto-profil', 'public');
                $user->foto = $picturePath;
            }
    
            // Simpan perubahan
            $user->save();
    
            // Redirect kembali ke halaman profil dengan pesan sukses
            return redirect('/dashboard/profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal mengubah profil. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
