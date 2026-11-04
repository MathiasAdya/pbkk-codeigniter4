<?php

namespace App\Libraries;

use App\Models\ProdukModel;

/** Keranjang belanja berbasis session: [produk_id => qty]. */
class Cart
{
    private const KEY = 'cart';

    private function raw(): array
    {
        return session()->get(self::KEY) ?? [];
    }

    /** Tambah qty; hasilnya dibatasi stok. Mengembalikan pesan error atau null. */
    public function add(int $id, int $qty): ?string
    {
        $produk = model(ProdukModel::class)->find($id);
        if (! $produk) {
            return 'Produk tidak ditemukan.';
        }
        if ($produk['stok'] < 1) {
            return 'Stok produk habis.';
        }

        $cart     = $this->raw();
        $baru     = ($cart[$id] ?? 0) + max(1, $qty);
        $cart[$id] = min($baru, (int) $produk['stok']);
        session()->set(self::KEY, $cart);

        return $baru > $produk['stok'] ? 'Jumlah dibatasi sesuai stok tersedia (' . $produk['stok'] . ').' : null;
    }

    /** Set qty; qty <= 0 menghapus item. Dibatasi stok. */
    public function set(int $id, int $qty): void
    {
        $cart = $this->raw();
        if (! isset($cart[$id])) {
            return;
        }
        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $stok     = (int) (model(ProdukModel::class)->find($id)['stok'] ?? 0);
            $cart[$id] = min($qty, max($stok, 1));
        }
        session()->set(self::KEY, $cart);
    }

    public function remove(int $id): void
    {
        $cart = $this->raw();
        unset($cart[$id]);
        session()->set(self::KEY, $cart);
    }

    public function clear(): void
    {
        session()->remove(self::KEY);
    }

    /** Daftar item lengkap dengan data produk dan subtotal. */
    public function items(): array
    {
        $cart = $this->raw();
        if (! $cart) {
            return [];
        }

        $items = [];
        foreach (model(ProdukModel::class)->whereIn('id', array_keys($cart))->findAll() as $p) {
            $p['qty']      = $cart[$p['id']];
            $p['subtotal'] = $p['qty'] * $p['harga'];
            $items[]       = $p;
        }

        return $items;
    }

    public function total(): int
    {
        return array_sum(array_column($this->items(), 'subtotal'));
    }

    public function count(): int
    {
        return array_sum($this->raw());
    }
}
