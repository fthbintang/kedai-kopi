<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ListBarangMasuk;


class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.barang-masuk', [
            'title' => 'Data Barang Masuk',
            'barangMasuk' => BarangMasuk::all(),
            'barangs' => Barang::all(),
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
    // public function store(Request $request)
    // {
    //     $rules = [
    //         'barang_id.*' => 'required|exists:barangs,id',
    //         'stok_sebelum.*' => 'required|integer',
    //         'stok_masuk.*' => 'required|integer',
    //     ];
    
    //     $messages = [
    //         'barang_id.*.required' => 'Nama Barang wajib diisi',
    //         'barang_id.*.exists' => 'Nama Barang tidak valid',
    //         'stok_sebelum.*.required' => 'Stok wajib diisi',
    //         'stok_sebelum.*.integer' => 'Stok harus berupa angka',
    //         'stok_masuk.*.required' => 'Stok Masuk wajib diisi',
    //         'stok_masuk.*.integer' => 'Stok Masuk harus berupa angka',
    //     ];
    
    //     $validator = Validator::make($request->all(), $rules, $messages);
    
    //     if ($validator->fails()) {
    //         return redirect('/dashboard/barang-masuk')
    //             ->withErrors($validator)
    //             ->withInput()
    //             ->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
    //     }
    
    //     // Loop untuk mengambil dan memproses input dinamis
    //     $barangIds = $request->input('barang_id');
    //     $stokSebelums = $request->input('stok_sebelum');
    //     $stokMasuks = $request->input('stok_masuk');
    
    //     foreach ($barangIds as $index => $barangId) {
    //         $stokSebelum = $stokSebelums[$index];
    //         $stokMasuk = $stokMasuks[$index];
    //         $stokSesudah = $stokSebelum + $stokMasuk;
    
    //         // Simpan data ke database
    //         BarangMasuk::create([
    //             'barang_id' => $barangId,
    //             'user_id' => auth()->user()->id,
    //             'stok_sebelum' => $stokSebelum,
    //             'stok_masuk' => $stokMasuk,
    //             'stok_sesudah' => $stokSesudah,
    //         ]);
    
    //         // Update atribut stok di tabel barangs
    //         $barang = Barang::find($barangId);
    //         $barang->stok = $stokSesudah;
    //         $barang->save();
    //     }
    
    //     return redirect('/dashboard/barang-masuk')->with('success', 'Tambah Data Berhasil!');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nama_sesi' => 'required',
                'keterangan' => 'nullable',
            ],
            [
                'nama_sesi' => 'Nama Sesi Wajib Diisi!',
            ]
        );
    
        try {
            // Tambahkan data barang masuk
            BarangMasuk::create([
                'nama_sesi' => $validatedData['nama_sesi'],
                'keterangan' => $validatedData['keterangan'],
                'user_id' => auth()->user()->id,
                'status' => 'Menunggu',
            ]);
    
            return redirect()->back()->with('success', 'Tambah Data Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $validatedData = $request->validate([
            'nama_sesi' => 'required',
            'keterangan' => 'nullable',
        ], [
            'nama_sesi.required' => 'Nama Wajib Diisi !',
        ]);

        try {
            $keterangan = $validatedData['keterangan'];
            $nama_sesi = $validatedData['nama_sesi'];

            // Update atribut stok di tabel barang_masuks
            $barangMasuk->keterangan = $keterangan;
            $barangMasuk->nama_sesi= $nama_sesi;
            $barangMasuk->save();

            return redirect()->back()->with('success', 'Edit Data Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error-update', 'Gagal mengedit data. Pastikan input yang Anda masukkan benar.');
        }
    }

    public function acc($id)
    {
        $barangMasuk = BarangMasuk::find($id);
    
        if ($barangMasuk) {
            $barangMasuk->status = 'ACC';
            $barangMasuk->save();
    
            // Ambil semua item terkait dari list_barang_masuks yang sudah di-ACC
            $listBarangMasuksACC = ListBarangMasuk::where('barang_masuk_id', $id)->get();
    
            // Lakukan perhitungan total stok_sesudah untuk update stok di tabel barangs
            foreach ($listBarangMasuksACC as $item) {
                $barang = Barang::find($item->barang_id);
                $barang->stok = $item->stok_sesudah; // Update nilai stok
                $barang->save(); // Simpan perubahan
            }
        }
    
        return redirect()->back()->with('success', 'Status ACC!');
    }
    
    
    public function notAcc($id)
    {
        $barangMasuk = BarangMasuk::find($id);
        
        if ($barangMasuk) {
            $barangMasuk->status = 'Tidak ACC';
            $barangMasuk->save();
        }
        
        return back()->with('notAcc', 'Status Tidak ACC!');
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, BarangMasuk $barangMasuk)
    // {
    //     $validatedData = $request->validate([
    //         'stok_sebelum' => 'required|integer',
    //         'stok_masuk' => 'required|integer',
    //     ], [
    //         'stok_sebelum.required' => 'Stok Wajib Diisi !',
    //         'stok_sebelum.integer' => 'Stok Diisi dengan Angka !',
    //     ]);

    //     try {
    //         $stokSebelum = $validatedData['stok_sebelum'];
    //         $stokMasuk = $validatedData['stok_masuk'];
    //         $stokSesudah = $stokSebelum + $stokMasuk;

    //         // Update atribut stok di tabel barang_masuks
    //         $barangMasuk->stok_sebelum = $stokSebelum;
    //         $barangMasuk->stok_masuk = $stokMasuk;
    //         $barangMasuk->stok_sesudah = $stokSesudah;
    //         $barangMasuk->save();

    //         // Update atribut stok di tabel barangs
    //         $barang = Barang::find($barangMasuk->barang_id);
    //         $barang->stok = $stokSesudah;
    //         $barang->save();

    //         return redirect('/dashboard/barang-masuk')->with('success', 'Edit Data Berhasil!');
    //     } catch (\Exception $e) {
    //         return back()->withInput()->with('error-update', 'Gagal mengedit data. Pastikan input yang Anda masukkan benar.');
    //     }
    // }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        BarangMasuk::destroy($barangMasuk->id);

        return redirect('/dashboard/barang-masuk')->with('success', 'Data Barang Masuk berhasil dihapus.');
    }
}
