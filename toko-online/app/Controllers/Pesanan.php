<?php

namespace App\Controllers;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;

/** Pesanan Saya (customer). */
class Pesanan extends BaseController
{
    public function index(): string
    {
        $model = model(OrderModel::class);

        return view('pesanan/index', [
            'title' => 'Pesanan Saya',
            'rows'  => $model->withPelanggan((int) user('id'))->paginate(10),
            'pager' => $model->pager,
        ]);
    }

    public function show(int $id): string
    {
        return view('pesanan/show', [
            'title' => "Pesanan #{$id}",
            'order' => $this->milik($id),
            'items' => model(OrderItemModel::class)->byOrder($id),
        ]);
    }

    public function batal(int $id)
    {
        try {
            model(OrderModel::class)->batalkan($id, (int) user('id'));
        } catch (RuntimeException $e) {
            return redirect()->to("/pesanan/{$id}")->with('error', $e->getMessage());
        }

        return redirect()->to("/pesanan/{$id}")->with('success', 'Pesanan dibatalkan dan stok dikembalikan.');
    }

    private function milik(int $id): array
    {
        return model(OrderModel::class)->withPelanggan((int) user('id'))->find($id)
            ?? throw new PageNotFoundException('Pesanan tidak ditemukan');
    }
}
