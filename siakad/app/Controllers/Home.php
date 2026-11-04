<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\MatakuliahModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home', [
            'stats' => [
                'Mahasiswa'  => model(MahasiswaModel::class)->countAllResults(),
                'Dosen'      => model(DosenModel::class)->countAllResults(),
                'Matakuliah' => model(MatakuliahModel::class)->countAllResults(),
            ],
        ]);
    }
}
