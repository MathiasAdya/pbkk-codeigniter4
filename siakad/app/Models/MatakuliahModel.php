<?php

namespace App\Models;

use CodeIgniter\Model;

class MatakuliahModel extends Model
{
    protected $table         = 'matakuliah';
    protected $allowedFields = ['kode', 'nama', 'sks', 'semester', 'dosen_id'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    protected $validationRules = [
        'id'       => 'permit_empty|is_natural_no_zero',
        'kode'     => 'required|alpha_numeric|max_length[10]|is_unique[matakuliah.kode,id,{id}]',
        'nama'     => 'required|max_length[100]',
        'sks'      => 'required|integer|greater_than[0]|less_than[7]',
        'semester' => 'required|integer|greater_than[0]|less_than[9]',
        'dosen_id' => 'permit_empty|is_not_unique[dosen.id]',
    ];

    /** Matakuliah beserta nama dosen pengampu. */
    public function withDosen(): self
    {
        return $this->select('matakuliah.*, dosen.nama AS dosen')
            ->join('dosen', 'dosen.id = matakuliah.dosen_id', 'left')
            ->orderBy('matakuliah.semester')->orderBy('matakuliah.kode');
    }
}
