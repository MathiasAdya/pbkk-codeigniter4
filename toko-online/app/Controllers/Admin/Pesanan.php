<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

class Pesanan extends BaseController
{
    public function index(): string
    {
        $model  = model(OrderModel::class);
        $status = (string) $this->request->getGet('status');
        $query  = $model->withPelanggan();
        if (in_array($status, OrderModel::STATUS, true)) {
            $query->where('orders.status', $status);
        }

        return view('admin/pesanan/index', [
            'title'  => 'Data Pesanan',
            'rows'   => $query->paginate(10),
            'pager'  => $model->pager,
            'status' => $status,
        ]);
    }

    public function show(int $id): string
    {
        $order = model(OrderModel::class)->withPelanggan()->find($id) ?? throw new PageNotFoundException('Pesanan tidak ditemukan');

        return view('admin/pesanan/show', [
            'title' => "Pesanan #{$id}",
            'order' => $order,
            'items' => model(OrderItemModel::class)->byOrder($id),
        ]);
    }

    public function status(int $id)
    {
        try {
            model(OrderModel::class)->ubahStatus($id, (string) $this->request->getPost('status'));
        } catch (RuntimeException $e) {
            return redirect()->to("/admin/pesanan/{$id}")->with('error', $e->getMessage());
        }

        return redirect()->to("/admin/pesanan/{$id}")->with('success', 'Status pesanan diperbarui.');
    }
}
