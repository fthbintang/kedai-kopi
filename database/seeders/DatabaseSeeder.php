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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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

        // Atribut::create([
        //     'nama_barang' => 'Sendok',
        //     'stok' => 10,
        //     'unit' => 'Kg' 
        // ]);

        // Atribut::create([
        //     'nama_barang' => 'Garpu',
        //     'stok' => 10,
        //     'unit' => 'Kg'
        // ]);

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

        // BahanBaku::create([
        //     'nama_bahan_baku' => 'Susu UHT',
        //     'stok' => 10,
        //     'unit' => 'liter'
        // ]);

        // BahanBaku::create([
        //     'nama_bahan_baku' => 'Susu Kental Manis',
        //     'stok' => 5,
        //     'unit' => 'liter'
        // ]);
    }
}
