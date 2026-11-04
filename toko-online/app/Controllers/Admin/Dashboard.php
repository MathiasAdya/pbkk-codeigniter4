<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProdukModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $orders = model(OrderModel::class);

        return view('admin/dashboard', [
            'title' => 'Dashboard',
            'stat'  => [
                'produk'     => model(ProdukModel::class)->countAllResults(),
                'pesanan'    => $orders->countAllResults(),
                'pendapatan' => (int) ($orders->builder()->selectSum('total')->whereIn('status', ['dibayar', 'dikirim', 'selesai'])->get()->getRowArray()['total'] ?? 0),
                'pelanggan'  => model(UserModel::class)->where('role', 'customer')->countAllResults(),
            ],
            'terbaru' => model(OrderModel::class)->withPelanggan()->findAll(5),
        ]);
    }
}
