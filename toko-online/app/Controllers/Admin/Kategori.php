<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;

class Kategori extends BaseController
{
    private KategoriModel $model;

    public function __construct()
    {
        $this->model = model(KategoriModel::class);
    }

    public function index(): string
    {
        return view('admin/kategori/index', ['title' => 'Data Kategori', 'rows' => $this->model->withJumlah()]);
    }

    public function new(): string
    {
        return view('admin/kategori/form', ['title' => 'Tambah Kategori', 'row' => null]);
    }

    public function create()
    {
        if (! $this->model->insert($this->request->getPost(['nama']))) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/kategori')->with('success', 'Kategori ditambahkan.');
    }

    public function edit(int $id): string
    {
        return view('admin/kategori/form', ['title' => 'Edit Kategori', 'row' => $this->findOr404($id)]);
    }

    public function update(int $id)
    {
        $this->findOr404($id);
        if (! $this->model->update($id, $this->request->getPost(['nama']))) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/kategori')->with('success', 'Kategori diperbarui.');
    }

    public function delete(int $id)
    {
        $this->findOr404($id);

        try {
            $this->model->delete($id);
        } catch (DatabaseException) {
            // FK produk -> kategori bersifat RESTRICT
            return redirect()->to('/admin/kategori')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        return redirect()->to('/admin/kategori')->with('success', 'Kategori dihapus.');
    }

    private function findOr404(int $id): array
    {
        return $this->model->find($id) ?? throw new PageNotFoundException('Kategori tidak ditemukan');
    }
}
