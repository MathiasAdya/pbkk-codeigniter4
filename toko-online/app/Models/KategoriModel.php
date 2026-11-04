<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table         = 'kategori';
    protected $allowedFields = ['nama'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
    protected $validationRules = ['nama' => 'required|max_length[100]'];
    protected $validationMessages = ['nama' => ['required' => 'Nama kategori wajib diisi.']];

    /** Kategori beserta jumlah produknya. */
    public function withJumlah(): array
    {
        return $this->select('kategori.*, (SELECT COUNT(*) FROM produk WHERE produk.kategori_id = kategori.id) AS jumlah_produk')
            ->orderBy('nama')->findAll();
    }
}
