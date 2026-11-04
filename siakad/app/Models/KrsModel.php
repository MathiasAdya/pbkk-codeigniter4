<?php

namespace App\Models;

use CodeIgniter\Model;

class KrsModel extends Model
{
    public const TAHUN_AJARAN = '2026/2027 Ganjil';
    public const MAX_SKS      = 24;

    protected $table         = 'krs';
    protected $allowedFields = ['mahasiswa_id', 'matakuliah_id', 'tahun_ajaran', 'nilai'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    /** KRS seorang mahasiswa (default: semester berjalan) beserta data matakuliah. */
    public function forMahasiswa(int $mahasiswaId, ?string $tahunAjaran = self::TAHUN_AJARAN): array
    {
        $builder = $this->select('krs.*, matakuliah.kode, matakuliah.nama, matakuliah.sks, dosen.nama AS dosen')
            ->join('matakuliah', 'matakuliah.id = krs.matakuliah_id')
            ->join('dosen', 'dosen.id = matakuliah.dosen_id', 'left')
            ->where('krs.mahasiswa_id', $mahasiswaId);

        if ($tahunAjaran !== null) {
            $builder->where('krs.tahun_ajaran', $tahunAjaran);
        }

        return $builder->orderBy('krs.tahun_ajaran')->orderBy('matakuliah.kode')->findAll();
    }

    /** Peserta sebuah matakuliah pada semester berjalan. */
    public function peserta(int $matakuliahId): array
    {
        return $this->select('krs.*, mahasiswa.nrp, mahasiswa.nama')
            ->join('mahasiswa', 'mahasiswa.id = krs.mahasiswa_id')
            ->where(['krs.matakuliah_id' => $matakuliahId, 'krs.tahun_ajaran' => self::TAHUN_AJARAN])
            ->orderBy('mahasiswa.nrp')->findAll();
    }

    /**
     * Ambil matakuliah. Mengembalikan pesan error, atau null bila berhasil.
     */
    public function ambil(int $mahasiswaId, array $matakuliah): ?string
    {
        $krs = $this->forMahasiswa($mahasiswaId);

        if (in_array($matakuliah['id'], array_column($krs, 'matakuliah_id'))) {
            return 'Matakuliah sudah ada di KRS.';
        }
        if (array_sum(array_column($krs, 'sks')) + $matakuliah['sks'] > self::MAX_SKS) {
            return 'Total SKS melebihi batas ' . self::MAX_SKS . ' SKS.';
        }

        $this->insert([
            'mahasiswa_id'  => $mahasiswaId,
            'matakuliah_id' => $matakuliah['id'],
            'tahun_ajaran'  => self::TAHUN_AJARAN,
        ]);

        return null;
    }
}
