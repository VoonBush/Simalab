<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama' => 'Admin',
            'npm' => null, // Assuming admin doesn't need npm
            'jurusan' => null,
            'prodi' => null,
            'email' => 'admin@simalab.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'Admin',
        ]);
    }
}
