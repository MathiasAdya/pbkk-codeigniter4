<?php

namespace App\Controllers;

use App\Models\KrsModel;
use App\Models\MahasiswaModel;
use App\Models\MatakuliahModel;

class Krs extends BaseController
{
    private KrsModel $krs;
    private array $mahasiswa;

    public function __construct()
    {
        $this->krs       = model(KrsModel::class);
        $this->mahasiswa = model(MahasiswaModel::class)->findByUser(user('id'));
    }

    public function index(): string
    {
        $krs   = $this->krs->forMahasiswa($this->mahasiswa['id']);
        $taken = array_column($krs, 'matakuliah_id');

        return view('krs/index', [
            'title'    => 'Kartu Rencana Studi',
            'krs'      => $krs,
            'totalSks' => array_sum(array_column($krs, 'sks')),
            'tersedia' => array_filter(
                model(MatakuliahModel::class)->withDosen()->findAll(),
                static fn ($mk) => ! in_array($mk['id'], $taken),
            ),
        ]);
    }

    public function ambil()
    {
        $mk = model(MatakuliahModel::class)->find((int) $this->request->getPost('matakuliah_id'));
        if (! $mk) {
            return redirect()->back()->with('error', 'Matakuliah tidak ditemukan.');
        }
        if ($error = $this->krs->ambil($this->mahasiswa['id'], $mk)) {
            return redirect()->back()->with('error', $error);
        }

        return redirect()->to('/krs')->with('success', "{$mk['nama']} ditambahkan ke KRS.");
    }

    public function drop(int $id)
    {
        // Hanya KRS milik sendiri, semester berjalan, dan belum dinilai
        $this->krs->where([
            'id'           => $id,
            'mahasiswa_id' => $this->mahasiswa['id'],
            'tahun_ajaran' => KrsModel::TAHUN_AJARAN,
        ])->where('nilai', null)->delete();

        return $this->krs->db->affectedRows()
            ? redirect()->to('/krs')->with('success', 'Matakuliah dibatalkan.')
            : redirect()->to('/krs')->with('error', 'Matakuliah tidak dapat dibatalkan.');
    }

    public function khs(): string
    {
        $rows      = $this->krs->forMahasiswa($this->mahasiswa['id'], null);
        $semesters = [];
        foreach ($rows as $row) {
            $semesters[$row['tahun_ajaran']][] = $row;
        }

        return view('krs/khs', [
            'title'     => 'Kartu Hasil Studi',
            'mahasiswa' => $this->mahasiswa,
            'semesters' => $semesters,
            'ipk'       => hitung_ip($rows),
        ]);
    }
}
