<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    use HasUserAccount;

    protected $table         = 'mahasiswa';
    protected $allowedFields = ['user_id', 'nrp', 'nama', 'angkatan', 'email', 'dosen_wali_id', 'foto'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    protected $validationRules = [
        'id'            => 'permit_empty|is_natural_no_zero',
        'nrp'           => 'required|numeric|max_length[20]|is_unique[mahasiswa.nrp,id,{id}]',
        'nama'          => 'required|max_length[100]',
        'angkatan'      => 'required|integer|greater_than[1999]|less_than[2100]',
        'email'         => 'permit_empty|valid_email',
        'dosen_wali_id' => 'permit_empty|is_not_unique[dosen.id]',
    ];

    /** Daftar mahasiswa beserta nama dosen wali, dengan pencarian opsional. */
    public function withWali(?string $keyword = null): self
    {
        $this->select('mahasiswa.*, dosen.nama AS dosen_wali')
            ->join('dosen', 'dosen.id = mahasiswa.dosen_wali_id', 'left');

        if ($keyword) {
            $this->groupStart()->like('mahasiswa.nama', $keyword)->orLike('mahasiswa.nrp', $keyword)->groupEnd();
        }

        return $this->orderBy('mahasiswa.nrp');
    }
}
