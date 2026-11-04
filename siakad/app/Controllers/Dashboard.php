<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\KrsModel;
use App\Models\MahasiswaModel;
use App\Models\MatakuliahModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = ['title' => 'Dashboard'];

        switch (session('role')) {
            case 'admin':
                $data['stats'] = [
                    ['Mahasiswa', model(MahasiswaModel::class)->countAllResults(), 'user-graduate', 'primary'],
                    ['Dosen', model(DosenModel::class)->countAllResults(), 'chalkboard-teacher', 'success'],
                    ['Matakuliah', model(MatakuliahModel::class)->countAllResults(), 'book', 'info'],
                    ['KRS Semester Ini', model(KrsModel::class)->where('tahun_ajaran', KrsModel::TAHUN_AJARAN)->countAllResults(), 'clipboard-list', 'warning'],
                ];
                break;

            case 'dosen':
                $dosen          = model(DosenModel::class)->findByUser(user('id'));
                $data['profil'] = $dosen;
                $data['stats']  = [
                    ['Matakuliah Diampu', model(MatakuliahModel::class)->where('dosen_id', $dosen['id'])->countAllResults(), 'book', 'primary'],
                    ['Mahasiswa Wali', model(MahasiswaModel::class)->where('dosen_wali_id', $dosen['id'])->countAllResults(), 'user-graduate', 'success'],
                ];
                break;

            case 'mahasiswa':
                $mhs            = model(MahasiswaModel::class)->findByUser(user('id'));
                $krsModel       = model(KrsModel::class);
                $ipk            = hitung_ip($krsModel->forMahasiswa($mhs['id'], null));
                $data['profil'] = $mhs;
                $data['stats']  = [
                    ['SKS Semester Ini', array_sum(array_column($krsModel->forMahasiswa($mhs['id']), 'sks')) . ' / ' . KrsModel::MAX_SKS, 'clipboard-list', 'primary'],
                    ['SKS Lulus', $ipk['sks'], 'check-circle', 'success'],
                    ['IPK', number_format($ipk['ip'], 2), 'star', 'warning'],
                ];
                break;
        }

        return view('dashboard', $data);
    }
}
