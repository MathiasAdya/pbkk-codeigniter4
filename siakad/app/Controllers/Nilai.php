<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\KrsModel;
use App\Models\MatakuliahModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Nilai extends BaseController
{
    private array $dosen;

    public function __construct()
    {
        $this->dosen = model(DosenModel::class)->findByUser(user('id'));
    }

    public function index(): string
    {
        $rows = model(MatakuliahModel::class)->where('dosen_id', $this->dosen['id'])->orderBy('kode')->findAll();
        $krs  = model(KrsModel::class);
        foreach ($rows as &$row) {
            $row['peserta'] = count($krs->peserta($row['id']));
        }

        return view('nilai/index', ['title' => 'Matakuliah Diampu', 'rows' => $rows]);
    }

    public function show(int $id): string
    {
        return view('nilai/show', [
            'title'   => 'Input Nilai',
            'mk'      => $this->ownedMatakuliah($id),
            'peserta' => model(KrsModel::class)->peserta($id),
            'pilihan' => array_keys(NILAI_BOBOT),
        ]);
    }

    public function save(int $id)
    {
        $this->ownedMatakuliah($id);
        $krs   = model(KrsModel::class);
        $valid = array_column($krs->peserta($id), 'id');

        foreach ((array) $this->request->getPost('nilai') as $krsId => $nilai) {
            // Abaikan id KRS yang bukan peserta matakuliah ini & nilai di luar daftar
            if (in_array((int) $krsId, $valid) && ($nilai === '' || array_key_exists($nilai, NILAI_BOBOT))) {
                $krs->update((int) $krsId, ['nilai' => $nilai === '' ? null : $nilai]);
            }
        }

        return redirect()->to("/nilai/{$id}")->with('success', 'Nilai disimpan.');
    }

    private function ownedMatakuliah(int $id): array
    {
        $mk = model(MatakuliahModel::class)->where(['id' => $id, 'dosen_id' => $this->dosen['id']])->first();

        return $mk ?? throw new PageNotFoundException('Matakuliah tidak ditemukan');
    }
}
