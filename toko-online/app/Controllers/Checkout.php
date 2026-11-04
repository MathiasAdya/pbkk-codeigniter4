<?php

namespace App\Controllers;

use App\Libraries\Cart;
use App\Models\OrderModel;
use RuntimeException;

class Checkout extends BaseController
{
    public function index()
    {
        $cart = new Cart();
        if (! $cart->items()) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang masih kosong.');
        }

        return view('toko/checkout', ['title' => 'Checkout', 'items' => $cart->items(), 'total' => $cart->total()]);
    }

    public function proses()
    {
        $cart  = new Cart();
        $items = $cart->items();
        if (! $items) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang masih kosong.');
        }

        if (! $this->validate(['alamat' => 'required|min_length[10]|max_length[500]'], [
            'alamat' => ['required' => 'Alamat pengiriman wajib diisi.', 'min_length' => 'Alamat pengiriman minimal 10 karakter.'],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $orderId = model(OrderModel::class)->buat(
                (int) user('id'),
                (string) $this->request->getPost('alamat'),
                array_map(static fn ($i) => ['id' => $i['id'], 'qty' => $i['qty']], $items),
            );
        } catch (RuntimeException $e) {
            return redirect()->to('/keranjang')->with('error', $e->getMessage());
        }

        $cart->clear();

        return redirect()->to("/pesanan/{$orderId}")->with('success', 'Pesanan berhasil dibuat.');
    }
}
