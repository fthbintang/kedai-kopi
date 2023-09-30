<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
            'name' => 'Ahmad Ariyanur Rahma',
            'username' => 'ari',
            'password' => bcrypt('ari'),
            'level' => 'admin'
        ]);
    }
}
