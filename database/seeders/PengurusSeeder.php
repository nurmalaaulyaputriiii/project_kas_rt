<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengurus;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        Pengurus::create([
            'nama' => 'Petugas Kas',
            'email' => 'pengurus@gmail.com',
            'password' => '12345678',
        ]);
    }
}