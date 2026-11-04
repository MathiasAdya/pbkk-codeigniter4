<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table          = 'users';
    protected $allowedFields  = ['username', 'password', 'nama', 'email', 'role'];
    protected $useTimestamps  = true;
    protected $returnType     = 'array';
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    /** Password selalu disimpan dalam bentuk hash. */
    protected function hashPassword(array $data): array
    {
        if (! empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }

        return $data;
    }

    /** Kembalikan user bila username & password cocok, selain itu null. */
    public function attempt(string $username, string $password): ?array
    {
        $user = $this->where('username', $username)->first();

        return ($user && password_verify($password, $user['password'])) ? $user : null;
    }
}
