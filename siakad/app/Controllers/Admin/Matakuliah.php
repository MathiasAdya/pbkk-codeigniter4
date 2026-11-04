<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\MatakuliahModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;

class Matakuliah extends BaseController
{
    private MatakuliahModel $model;

    public function __construct()
    {
        $this->model = model(MatakuliahModel::class);
    }

    public function index(): string
    {
        return view('admin/matakuliah/index', ['title' => 'Data Matakuliah', 'rows' => $this->model->withDosen()->findAll()]);
    }

    public function new(): string
    {
        return $this->form('Tambah Matakuliah', null);
    }

    public function create()
    {
        if (! $this->model->insert($this->input())) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/matakuliah')->with('success', 'Matakuliah ditambahkan.');
    }

    public function edit(int $id): string
    {
        return $this->form('Edit Matakuliah', $this->findOr404($id));
    }

    public function update(int $id)
    {
        $this->findOr404($id);
        if (! $this->model->update($id, ['id' => $id] + $this->input())) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/matakuliah')->with('success', 'Matakuliah diperbarui.');
    }

    public function delete(int $id)
    {
        $this->findOr404($id);
        try {
            $this->model->delete($id);
        } catch (DatabaseException) {
            // FK krs.matakuliah_id ON DELETE RESTRICT
            return redirect()->back()->with('error', 'Matakuliah sudah diambil mahasiswa (ada di KRS), tidak bisa dihapus.');
        }

        return redirect()->to('/admin/matakuliah')->with('success', 'Matakuliah dihapus.');
    }

    private function input(): array
    {
        $data = $this->request->getPost(['kode', 'nama', 'sks', 'semester', 'dosen_id']);
        $data['dosen_id'] = $data['dosen_id'] ?: null;

        return $data;
    }

    private function form(string $title, ?array $row): string
    {
        return view('admin/matakuliah/form', [
            'title' => $title,
            'row'   => $row,
            'dosen' => model(DosenModel::class)->orderBy('nama')->findAll(),
        ]);
    }

    private function findOr404(int $id): array
    {
        return $this->model->find($id) ?? throw new PageNotFoundException('Matakuliah tidak ditemukan');
    }
}
