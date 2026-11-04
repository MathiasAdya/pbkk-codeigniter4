<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Dosen extends BaseController
{
    private DosenModel $model;

    public function __construct()
    {
        $this->model = model(DosenModel::class);
    }

    public function index(): string
    {
        return view('admin/dosen/index', ['title' => 'Data Dosen', 'rows' => $this->model->orderBy('nama')->findAll()]);
    }

    public function new(): string
    {
        return view('admin/dosen/form', ['title' => 'Tambah Dosen', 'row' => null]);
    }

    public function create()
    {
        $data = $this->request->getPost(['nidn', 'nama', 'email']);
        if (! $this->model->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
        if ($error = $this->model->createWithUser($data, $data['nidn'], 'dosen')) {
            return redirect()->back()->withInput()->with('error', $error);
        }

        return redirect()->to('/admin/dosen')->with('success', 'Dosen ditambahkan. Login: NIDN / NIDN.');
    }

    public function edit(int $id): string
    {
        return view('admin/dosen/form', ['title' => 'Edit Dosen', 'row' => $this->findOr404($id)]);
    }

    public function update(int $id)
    {
        $this->findOr404($id);
        $data = ['id' => $id] + $this->request->getPost(['nidn', 'nama', 'email']);
        if (! $this->model->updateWithUser($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/dosen')->with('success', 'Data dosen diperbarui.');
    }

    public function delete(int $id)
    {
        // Matakuliah & mahasiswa wali di-set NULL oleh foreign key
        model(UserModel::class)->delete($this->findOr404($id)['user_id']);

        return redirect()->to('/admin/dosen')->with('success', 'Dosen dihapus.');
    }

    private function findOr404(int $id): array
    {
        return $this->model->find($id) ?? throw new PageNotFoundException('Dosen tidak ditemukan');
    }
}
