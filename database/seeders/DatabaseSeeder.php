<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Atribut;
use App\Models\Barang;

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
            'level' => 'admin'
        ]);

        User::create([
            'name' => 'Ahmad Ariyanur Rahman',
            'username' => 'ari',
            'password' => bcrypt('ari'),
            'level' => 'admin'
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
    }
}
