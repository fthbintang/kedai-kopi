<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\ListBarangMasuk;
use App\Models\ListBarangKeluar;
use App\Models\PendapatanHarian;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'level' => '1'
        ]);

        User::create([
            'name' => 'Owner',
            'username' => 'owner',
            'password' => bcrypt('owner'),
            'level' => '2'
        ]);

        User::create([
            'name' => 'Pekerja',
            'username' => 'pekerja',
            'password' => bcrypt('pekerja'),
            'level' => '3'
        ]);

        Barang::create([
            'nama_barang' => 'Sendok',
            'stok' => 10,
            'unit' => 'Kg',
            'jenis' => 'Atribut'
        ]);

        Barang::create([
            'nama_barang' => 'Garpu',
            'stok' => 10,
            'unit' => 'Kg',
            'jenis' => 'Atribut'
        ]);

        Barang::create([
            'nama_barang' => 'Biji Kopi Aceh Gayo',
            'stok' => 5,
            'unit' => 'Kg',
            'jenis' => 'Bahan Baku'
        ]);

        Barang::create([
            'nama_barang' => 'LA Ice Purpleboost',
            'stok' => 20,
            'unit' => 'Kg',
            'jenis' => 'Tembakau'
        ]);

        // BarangMasuk::create([
        //     'nama_sesi' => 'Penambahan 2 stok',
        //     'user_id' => 1,
        //     'status' => 'Menunggu',
        //     'keterangan' => 'Tidak ada Keterangan'
        // ]);

        // BarangMasuk::create([
        //     'nama_sesi' => 'Penambahan 5 stok',
        //     'user_id' => 1,
        //     'status' => 'Menunggu',
        //     'keterangan' => 'Ini adalah keterangan'
        // ]);

        // BarangMasuk::create([
        //     'nama_sesi' => 'Penambahan 5 stok',
        //     'user_id' => 1,
        //     'status' => 'Menunggu',
        //     'keterangan' => 'Ini adalah keterangan yang kedua'
        // ]);

        // ListBarangMasuk::create([
        //     'barang_id' => 1,
        //     'barang_masuk_id' => 1,
        //     'stok_masuk' => 1,
        //     'stok_sebelum' => 10,
        //     'stok_sesudah' => 11,
        // ]);

        // ListBarangMasuk::create([
        //     'barang_id' => 1,
        //     'barang_masuk_id' => 1,
        //     'stok_masuk' => 50,
        //     'stok_sebelum' => 50,
        //     'stok_sesudah' => 50,
        // ]);

        // ListBarangMasuk::create([
        //     'barang_id' => 2,
        //     'barang_masuk_id' => 3,
        //     'stok_masuk' => 50,
        //     'stok_sebelum' => 50,
        //     'stok_sesudah' => 50,
        // ]);

        // BarangKeluar::create([
        //     'nama_sesi' => 'Pengurangan 2 Stok',
        //     'user_id' => 1,
        //     'status' => 'Menunggu',
        // ]);

        // BarangKeluar::create([
        //     'nama_sesi' => 'Pengurangan 5 Stok',
        //     'user_id' => 1,
        //     'status' => 'Menunggu', 
        // ]);

        // ListBarangKeluar::create([
        //     'barang_id' => 2,
        //     'barang_keluar_id' => 1,
        //     'stok_keluar' => 50,
        //     'stok_sebelum' => 50,
        //     'stok_sesudah' => 50,
        // ]);

        // ListBarangKeluar::create([
        //     'barang_id' => 3,
        //     'barang_keluar_id' => 2,
        //     'stok_keluar' => 50,
        //     'stok_sebelum' => 50,
        //     'stok_sesudah' => 50,
        // ]);

        PendapatanHarian::create([
            'tanggal' => now()->toDateString(),
            'pendapatan' => 500000,
        ]);
    }
}
