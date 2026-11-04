<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session('logged_in')) {
            return $this->home(session('role'));
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $user = model(UserModel::class)->attempt(
            (string) $this->request->getPost('username'),
            (string) $this->request->getPost('password'),
        );

        if ($user === null) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        return $this->masuk($user);
    }

    public function register()
    {
        if (session('logged_in')) {
            return $this->home(session('role'));
        }

        return view('auth/register');
    }

    public function store()
    {
        $rules = [
            'nama'             => 'required|max_length[100]',
            'username'         => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username]',
            'email'            => 'required|valid_email|max_length[100]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];
        $messages = [
            'username'         => ['is_unique' => 'Username sudah dipakai.', 'alpha_numeric' => 'Username hanya boleh huruf dan angka.'],
            'password_confirm' => ['matches' => 'Konfirmasi password tidak sama.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = model(UserModel::class);
        $id    = $users->insert($this->request->getPost(['username', 'password', 'nama', 'email']) + ['role' => 'customer']);

        return $this->masuk($users->find($id));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }

    /** Simpan sesi login, lalu arahkan sesuai role / tujuan semula. */
    private function masuk(array $user)
    {
        $intended = session('intended');
        session()->regenerate();
        session()->set([
            'logged_in' => true,
            'role'      => $user['role'],
            'user'      => ['id' => $user['id'], 'username' => $user['username'], 'nama' => $user['nama'], 'role' => $user['role']],
        ]);

        if ($user['role'] === 'customer' && $intended && ! str_starts_with($intended, 'admin')) {
            return redirect()->to('/' . $intended);
        }

        return $this->home($user['role']);
    }

    private function home(string $role)
    {
        return redirect()->to($role === 'admin' ? '/admin' : '/');
    }
}
