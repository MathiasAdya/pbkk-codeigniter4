<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ProdukModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;

class Produk extends BaseController
{
    private const GAMBAR_DIR  = FCPATH . 'uploads/produk/';
    private const GAMBAR_RULE = 'is_image[gambar]|mime_in[gambar,image/jpeg,image/png,image/webp]|max_size[gambar,2048]';

    private ProdukModel $model;

    public function __construct()
    {
        $this->model = model(ProdukModel::class);
    }

    public function index(): string
    {
        $q = trim((string) $this->request->getGet('q'));

        return view('admin/produk/index', [
            'title' => 'Data Produk',
            'rows'  => $this->model->daftar($q)->paginate(10),
            'pager' => $this->model->pager,
            'q'     => $q,
        ]);
    }

    public function new(): string
    {
        return $this->form('Tambah Produk', null);
    }

    public function create()
    {
        $data = $this->input();
        if (! $this->model->validate($data) || ! $this->validate(['gambar' => 'permit_empty|' . self::GAMBAR_RULE])) {
            return $this->back();
        }

        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid()) {
            $data['gambar'] = $this->simpan($file);
        }
        $this->model->insert($data, false);

        return redirect()->to('/admin/produk')->with('success', 'Produk ditambahkan.');
    }

    public function edit(int $id): string
    {
        return $this->form('Edit Produk', $this->findOr404($id));
    }

    public function update(int $id)
    {
        $row  = $this->findOr404($id);
        $data = $this->input();
        if (! $this->model->validate($data) || ! $this->validate(['gambar' => 'permit_empty|' . self::GAMBAR_RULE])) {
            return $this->back();
        }

        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid()) {
            $data['gambar'] = $this->simpan($file);
            $this->hapusFile($row['gambar']);
        }
        $this->model->update($id, $data);

        return redirect()->to('/admin/produk')->with('success', 'Produk diperbarui.');
    }

    public function delete(int $id)
    {
        $row = $this->findOr404($id);

        try {
            $this->model->delete($id);
        } catch (DatabaseException) {
            // FK order_items -> produk bersifat RESTRICT
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak dapat dihapus karena sudah pernah dipesan.');
        }
        $this->hapusFile($row['gambar']);

        return redirect()->to('/admin/produk')->with('success', 'Produk dihapus.');
    }

    private function input(): array
    {
        return $this->request->getPost(['kategori_id', 'nama', 'deskripsi', 'harga', 'stok']);
    }

    private function simpan(UploadedFile $file): string
    {
        $name = $file->getRandomName();
        $file->move(self::GAMBAR_DIR, $name);

        return $name;
    }

    private function hapusFile(?string $name): void
    {
        if ($name) {
            @unlink(self::GAMBAR_DIR . $name);
        }
    }

    private function back()
    {
        return redirect()->back()->withInput()->with('errors', $this->model->errors() + ($this->validator?->getErrors() ?? []));
    }

    private function form(string $title, ?array $row): string
    {
        return view('admin/produk/form', [
            'title'    => $title,
            'row'      => $row,
            'kategori' => model(KategoriModel::class)->orderBy('nama')->findAll(),
        ]);
    }

    private function findOr404(int $id): array
    {
        return $this->model->find($id) ?? throw new PageNotFoundException('Produk tidak ditemukan');
    }
}
