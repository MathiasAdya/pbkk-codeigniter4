<?php

namespace App\Models;

/**
 * Dipakai MahasiswaModel & DosenModel: menyimpan data profil sekaligus akun login
 * dalam satu transaksi. Username & password awal = $username (NRP / NIDN).
 */
trait HasUserAccount
{
    /** Mengembalikan pesan error, atau null bila berhasil. */
    public function createWithUser(array $data, string $username, string $role): ?string
    {
        $users = model(UserModel::class);
        $this->db->transBegin();

        $userId = $users->insert(['username' => $username, 'password' => $username, 'nama' => $data['nama'], 'role' => $role]);

        if ($userId && $this->insert($data + ['user_id' => $userId])) {
            $this->db->transCommit();

            return null;
        }

        $this->db->transRollback();

        return $userId ? implode(' ', $this->errors()) : 'Username ' . $username . ' sudah dipakai akun lain.';
    }

    /** Sinkronkan nama di tabel users bila profil diubah. */
    public function updateWithUser(int $id, array $data): bool
    {
        $row = $this->find($id);
        if (! $row || ! $this->update($id, $data)) {
            return false;
        }
        model(UserModel::class)->update($row['user_id'], ['nama' => $data['nama']]);

        return true;
    }

    public function findByUser(int $userId): ?array
    {
        return $this->where('user_id', $userId)->first();
    }
}
