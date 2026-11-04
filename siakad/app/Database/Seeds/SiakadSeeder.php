<?php

namespace App\Database\Seeds;

use App\Models\DosenModel;
use App\Models\KrsModel;
use App\Models\MahasiswaModel;
use App\Models\MatakuliahModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class SiakadSeeder extends Seeder
{
    public function run()
    {
        model(UserModel::class)->insert(['username' => 'admin', 'password' => 'admin123', 'nama' => 'Administrator', 'role' => 'admin']);

        $dosen = model(DosenModel::class);
        foreach ([
            ['nidn' => '0011223301', 'nama' => 'Fajar Baskoro, S.Kom., M.T.', 'email' => 'fajar@its.ac.id'],
            ['nidn' => '0011223302', 'nama' => 'Dr. Rina Wulandari, S.Kom.', 'email' => 'rina@its.ac.id'],
        ] as $row) {
            $dosen->createWithUser($row, $row['nidn'], 'dosen');
        }

        $mk = model(MatakuliahModel::class);
        $mk->insertBatch([
            ['kode' => 'IF4501', 'nama' => 'Pemrograman Berbasis Kerangka Kerja', 'sks' => 3, 'semester' => 5, 'dosen_id' => 1],
            ['kode' => 'IF4502', 'nama' => 'Basis Data Lanjut', 'sks' => 3, 'semester' => 5, 'dosen_id' => 2],
            ['kode' => 'IF4503', 'nama' => 'Rekayasa Perangkat Lunak', 'sks' => 3, 'semester' => 5, 'dosen_id' => 1],
            ['kode' => 'IF4504', 'nama' => 'Jaringan Komputer', 'sks' => 4, 'semester' => 5, 'dosen_id' => 2],
            ['kode' => 'IF4505', 'nama' => 'Kecerdasan Buatan', 'sks' => 3, 'semester' => 5, 'dosen_id' => null],
        ]);

        $mhs = model(MahasiswaModel::class);
        foreach ([
            ['nrp' => '5025231015', 'nama' => 'Mathias Adya Diwangkara Suganda', 'angkatan' => 2023, 'email' => 'mathias@student.its.ac.id', 'dosen_wali_id' => 1],
            ['nrp' => '5025231016', 'nama' => 'Budi Santoso', 'angkatan' => 2023, 'email' => 'budi@student.its.ac.id', 'dosen_wali_id' => 1],
            ['nrp' => '5025231017', 'nama' => 'Citra Lestari', 'angkatan' => 2023, 'email' => 'citra@student.its.ac.id', 'dosen_wali_id' => 2],
        ] as $row) {
            $mhs->createWithUser($row, $row['nrp'], 'mahasiswa');
        }

        // KRS semester lalu (sudah dinilai) dan semester berjalan
        $krs = model(KrsModel::class);
        $krs->insertBatch([
            ['mahasiswa_id' => 1, 'matakuliah_id' => 1, 'tahun_ajaran' => '2025/2026 Genap', 'nilai' => 'A'],
            ['mahasiswa_id' => 1, 'matakuliah_id' => 2, 'tahun_ajaran' => '2025/2026 Genap', 'nilai' => 'AB'],
            ['mahasiswa_id' => 1, 'matakuliah_id' => 3, 'tahun_ajaran' => KrsModel::TAHUN_AJARAN, 'nilai' => null],
            ['mahasiswa_id' => 2, 'matakuliah_id' => 1, 'tahun_ajaran' => KrsModel::TAHUN_AJARAN, 'nilai' => null],
            ['mahasiswa_id' => 3, 'matakuliah_id' => 1, 'tahun_ajaran' => KrsModel::TAHUN_AJARAN, 'nilai' => null],
        ]);
    }
}
