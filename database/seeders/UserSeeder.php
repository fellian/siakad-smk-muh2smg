<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@smkmuh2smg.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Guru contoh
        $guruUser = User::create([
            'name' => 'Fellian Satriabudi',
            'email' => 'guru@smkmuh2smg.sch.id',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
        ]);

        Guru::create([
            'nip' => '198501012010011001',
            'nama_lengkap' => 'Fellian Satriabudi',
            'jenis_kelamin' => 'L',
            'user_id' => $guruUser->id,
        ]);

        // Siswa contoh
        $siswaUser = User::create([
            'name' => 'Alek Candra',
            'email' => 'siswa@smkmuh2smg.sch.id',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'nis' => '20250001',
            'nama_lengkap' => 'Alek Candra',
            'jenis_kelamin' => 'L',
            'tanggal_masuk' => '2025-07-01',
            'user_id' => $siswaUser->id,
        ]);
    }
}