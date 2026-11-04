<?php

namespace App\Controllers;

use App\Libraries\Cart;

class Keranjang extends BaseController
{
    private Cart $cart;

    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function index(): string
    {
        return view('toko/keranjang', [
            'title' => 'Keranjang Belanja',
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function tambah()
    {
        $error = $this->cart->add((int) $this->request->getPost('produk_id'), (int) $this->request->getPost('qty'));

        return redirect()->to('/keranjang')->with($error ? 'error' : 'success', $error ?? 'Produk ditambahkan ke keranjang.');
    }

    public function update()
    {
        foreach ((array) $this->request->getPost('qty') as $id => $qty) {
            $this->cart->set((int) $id, (int) $qty);
        }

        return redirect()->to('/keranjang')->with('success', 'Keranjang diperbarui.');
    }

    public function hapus(int $id)
    {
        $this->cart->remove($id);

        return redirect()->to('/keranjang')->with('success', 'Item dihapus dari keranjang.');
    }
}
