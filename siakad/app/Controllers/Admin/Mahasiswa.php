<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Mahasiswa extends BaseController
{
    private const FOTO_DIR = FCPATH . 'uploads/foto/';
    private const FOTO_RULE = 'is_image[foto]|max_size[foto,1024]|mime_in[foto,image/jpeg,image/png,image/webp]';

    private MahasiswaModel $model;

    public function __construct()
    {
        $this->model = model(MahasiswaModel::class);
    }

    public function index(): string
    {
        $q = $this->request->getGet('q');

        return view('admin/mahasiswa/index', [
            'title' => 'Data Mahasiswa',
            'rows'  => $this->model->withWali($q)->paginate(10),
            'pager' => $this->model->pager,
            'q'     => $q,
        ]);
    }

    public function new(): string
    {
        return $this->form('Tambah Mahasiswa', null);
    }

    public function create()
    {
        $data = $this->input();
        if (! $this->model->validate($data) || ! $this->validate(['foto' => 'uploaded[foto]|' . self::FOTO_RULE])) {
            return $this->back();
        }

        $data['foto'] = $this->storeFoto($this->request->getFile('foto'));
        if ($error = $this->model->createWithUser($data, $data['nrp'], 'mahasiswa')) {
            @unlink(self::FOTO_DIR . $data['foto']);

            return redirect()->back()->withInput()->with('error', $error);
        }

        return redirect()->to('/admin/mahasiswa')->with('success', 'Mahasiswa ditambahkan. Login: NRP / NRP.');
    }

    public function edit(int $id): string
    {
        return $this->form('Edit Mahasiswa', $this->findOr404($id));
    }

    public function update(int $id)
    {
        $row  = $this->findOr404($id);
        $data = ['id' => $id] + $this->input();
        $foto = $this->request->getFile('foto');

        if (! $this->model->validate($data) || ($foto->isValid() && ! $this->validate(['foto' => self::FOTO_RULE]))) {
            return $this->back();
        }

        if ($foto->isValid()) {
            $data['foto'] = $this->storeFoto($foto);
            if ($row['foto']) {
                @unlink(self::FOTO_DIR . $row['foto']);
            }
        }
        $this->model->updateWithUser($id, $data);

        return redirect()->to('/admin/mahasiswa')->with('success', 'Data mahasiswa diperbarui.');
    }

    public function delete(int $id)
    {
        $row = $this->findOr404($id);
        // Hapus akun -> profil mahasiswa & KRS ikut terhapus (ON DELETE CASCADE)
        model(UserModel::class)->delete($row['user_id']);
        if ($row['foto']) {
            @unlink(self::FOTO_DIR . $row['foto']);
        }

        return redirect()->to('/admin/mahasiswa')->with('success', 'Mahasiswa dihapus.');
    }

    private function input(): array
    {
        $data = $this->request->getPost(['nrp', 'nama', 'angkatan', 'email', 'dosen_wali_id']);
        $data['dosen_wali_id'] = $data['dosen_wali_id'] ?: null;

        return $data;
    }

    private function storeFoto(UploadedFile $file): string
    {
        $name = $file->getRandomName();
        $file->move(self::FOTO_DIR, $name);

        return $name;
    }

    private function back()
    {
        return redirect()->back()->withInput()->with('errors', $this->model->errors() + ($this->validator?->getErrors() ?? []));
    }

    private function form(string $title, ?array $row): string
    {
        return view('admin/mahasiswa/form', [
            'title' => $title,
            'row'   => $row,
            'dosen' => model(DosenModel::class)->orderBy('nama')->findAll(),
        ]);
    }

    private function findOr404(int $id): array
    {
        return $this->model->find($id) ?? throw new \CodeIgniter\Exceptions\PageNotFoundException('Mahasiswa tidak ditemukan');
    }
}
