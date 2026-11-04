<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table         = 'produk';
    protected $allowedFields = ['kategori_id', 'nama', 'deskripsi', 'harga', 'stok', 'gambar'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
    protected $validationRules = [
        'kategori_id' => 'required|is_natural_no_zero|is_not_unique[kategori.id]',
        'nama'        => 'required|max_length[150]',
        'deskripsi'   => 'permit_empty',
        'harga'       => 'required|is_natural',
        'stok'        => 'required|is_natural',
    ];
    protected $validationMessages = [
        'kategori_id' => ['required' => 'Kategori wajib dipilih.', 'is_not_unique' => 'Kategori tidak valid.', 'is_natural_no_zero' => 'Kategori wajib dipilih.'],
        'nama'        => ['required' => 'Nama produk wajib diisi.'],
        'harga'       => ['required' => 'Harga wajib diisi.', 'is_natural' => 'Harga harus berupa angka bulat >= 0.'],
        'stok'        => ['required' => 'Stok wajib diisi.', 'is_natural' => 'Stok harus berupa angka bulat >= 0.'],
    ];

    /** Produk + nama kategori, dengan filter pencarian & kategori opsional. */
    public function daftar(?string $q = null, ?int $kategoriId = null): static
    {
        $this->select('produk.*, kategori.nama AS kategori')
            ->join('kategori', 'kategori.id = produk.kategori_id')
            ->orderBy('produk.id', 'DESC');

        if ($q) {
            $this->like('produk.nama', $q);
        }
        if ($kategoriId) {
            $this->where('produk.kategori_id', $kategoriId);
        }

        return $this;
    }

    public function detail(int $id): ?array
    {
        return $this->select('produk.*, kategori.nama AS kategori')
            ->join('kategori', 'kategori.id = produk.kategori_id')
            ->where('produk.id', $id)->first();
    }
}
