<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ProdukModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/** Etalase publik: daftar & detail produk. */
class Toko extends BaseController
{
    public function index(): string
    {
        $q        = trim((string) $this->request->getGet('q'));
        $kategori = (int) $this->request->getGet('kategori');
        $model    = model(ProdukModel::class);

        return view('toko/index', [
            'title'    => 'Beranda',
            'produk'   => $model->daftar($q, $kategori)->paginate(9),
            'pager'    => $model->pager,
            'kategori' => model(KategoriModel::class)->orderBy('nama')->findAll(),
            'q'        => $q,
            'aktif'    => $kategori,
        ]);
    }

    public function detail(int $id): string
    {
        $produk = model(ProdukModel::class)->detail($id) ?? throw new PageNotFoundException('Produk tidak ditemukan');

        return view('toko/detail', ['title' => $produk['nama'], 'p' => $produk]);
    }
}
