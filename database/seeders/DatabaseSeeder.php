<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\ListBarangMasuk;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Muhammad Bintang Fathehah',
            'username' => 'bintang',
            'password' => bcrypt('bintang'),
            'level' => '1'
        ]);

        User::create([
            'name' => 'Ahmad Ariyanur Rahman',
            'username' => 'ari',
            'password' => bcrypt('ari'),
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

        BarangMasuk::create([
            'nama_sesi' => 'Penambahan 2 stok',
            'user_id' => 1,
            'status' => 'Menunggu',
        ]);

        ListBarangMasuk::create([
            'barang_id' => 1,
            'barang_masuk_id' => 1,
            'stok_masuk' => 1,
            'stok_sebelum' => 10,
            'stok_sesudah' => 11,
        ]);

        BarangKeluar::create([
            'barang_id' => 2,
            'user_id' => 1,
            'stok_keluar' => 10,
            'stok_sebelum' => 10,
            'stok_sesudah' => 10,
        ]);

    }
}
