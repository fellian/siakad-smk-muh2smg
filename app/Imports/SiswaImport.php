<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {   
        if (empty($row['nis']) || empty($row['nama_lengkap'])) {
            return null;
        }


        return DB::transaction(function () use ($row) {
            

            $emailLoginOtomatis = trim($row['nis']) . '@siswa.sekolah.sch.id';

            $user = User::where('email', $emailLoginOtomatis)->first();

            if (!$user) {
                
                $passwordRaw = 'siswa123';
                if (!empty($row['tanggal_lahir'])) {
                    try {
                        
                        $date = is_numeric($row['tanggal_lahir']) 
                            ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])
                            : new \DateTime($row['tanggal_lahir']);
                        
                        $passwordRaw = $date->format('dmY');
                    } catch (\Exception $e) {
                        $passwordRaw = 'siswa123';
                    }
                }

                $user = User::create([
                    'name'     => $row['nama_lengkap'],
                    'email'    => $emailLoginOtomatis,
                    'password' => Hash::make($passwordRaw),
                    'role'     => 'siswa', 
                ]);
            }

            $siswaLama = Siswa::where('nis', $row['nis'])->first();
            if ($siswaLama) {
                return null;
            }

            $transformDate = function($value) {
                if (empty($value)) return null;
                try {
                    return is_numeric($value)
                        ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d')
                        : Carbon::parse($value)->format('Y-m-d');
                } catch (\Exception $e) {
                    return null;
                }
            };

            return new Siswa([
                'nis'             => $row['nis'],
                'nisn'            => $row['nisn'] ?? null,
                'nama_lengkap'    => $row['nama_lengkap'],
                'jenis_kelamin'   => $row['jenis_kelamin'],
                'tempat_lahir'    => $row['tempat_lahir'] ?? null,
                'tanggal_lahir'   => $transformDate($row['tanggal_lahir']),
                'alamat'          => $row['alamat'] ?? null,
                'no_hp'           => $row['no_hp'] ?? null,
                'email'           => $row['email'] ?? null, 
                'nama_ortu'       => $row['nama_ortu'] ?? null,
                'no_hp_ortu'      => $row['no_hp_ortu'] ?? null,
                'kelas_id'        => $row['kelas_id'] ?? null,
                'status'          => $row['status'] ?? 'aktif',
                'tanggal_masuk'   => $transformDate($row['tanggal_masuk']) ?? now()->format('Y-m-d'),
                'tanggal_keluar'  => null,
                'foto'            => null,
                'user_id'         => $user->id, 
            ]);
        });
    }
}