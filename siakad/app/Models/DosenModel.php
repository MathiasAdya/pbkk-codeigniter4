<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    use HasUserAccount;

    protected $table         = 'dosen';
    protected $allowedFields = ['user_id', 'nidn', 'nama', 'email'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    protected $validationRules = [
        'id'    => 'permit_empty|is_natural_no_zero',
        'nidn'  => 'required|numeric|max_length[20]|is_unique[dosen.nidn,id,{id}]',
        'nama'  => 'required|max_length[100]',
        'email' => 'permit_empty|valid_email',
    ];
}
