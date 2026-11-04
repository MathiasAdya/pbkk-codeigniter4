<?php

namespace App\Models;

use CodeIgniter\Model;
use RuntimeException;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $allowedFields = ['user_id', 'total', 'alamat', 'status'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    public const STATUS = ['pending', 'dibayar', 'dikirim', 'selesai', 'batal'];

    /** Order + nama pelanggan; filter user_id bila diberikan. */
    public function withPelanggan(?int $userId = null): static
    {
        $this->select('orders.*, users.nama AS pelanggan, users.username')
            ->join('users', 'users.id = orders.user_id')
            ->orderBy('orders.id', 'DESC');

        return $userId ? $this->where('orders.user_id', $userId) : $this;
    }

    /**
     * Buat order dari item keranjang dalam satu transaksi.
     * Stok dikunci (FOR UPDATE), dicek, lalu dikurangi. Harga disimpan sebagai snapshot.
     *
     * @param list<array{id:int, qty:int}> $items
     *
     * @throws RuntimeException bila stok tidak mencukupi
     */
    public function buat(int $userId, string $alamat, array $items): int
    {
        $db = $this->db;
        $db->transBegin();

        try {
            $total = 0;
            $baris = [];
            foreach ($items as $item) {
                $p = $db->query('SELECT id, nama, harga, stok FROM produk WHERE id = ? FOR UPDATE', [$item['id']])->getRowArray();
                if (! $p) {
                    throw new RuntimeException('Produk dalam keranjang sudah tidak tersedia.');
                }
                if ($p['stok'] < $item['qty']) {
                    throw new RuntimeException("Stok \"{$p['nama']}\" tidak mencukupi (tersisa {$p['stok']}).");
                }
                $total += $p['harga'] * $item['qty'];
                $baris[] = ['produk_id' => $p['id'], 'qty' => $item['qty'], 'harga' => $p['harga']];
                $db->query('UPDATE produk SET stok = stok - ? WHERE id = ?', [$item['qty'], $p['id']]);
            }

            $orderId = $this->insert(['user_id' => $userId, 'total' => $total, 'alamat' => $alamat, 'status' => 'pending'], true);
            foreach ($baris as $b) {
                model(OrderItemModel::class)->insert($b + ['order_id' => $orderId]);
            }

            $db->transCommit();

            return (int) $orderId;
        } catch (\Throwable $e) {
            $db->transRollback();

            throw $e instanceof RuntimeException ? $e : new RuntimeException('Gagal membuat pesanan, silakan coba lagi.', 0, $e);
        }
    }

    /**
     * Ubah status. Status "batal" bersifat final dan mengembalikan stok.
     *
     * @throws RuntimeException bila perubahan tidak diperbolehkan
     */
    public function ubahStatus(int $id, string $status): void
    {
        if (! in_array($status, self::STATUS, true)) {
            throw new RuntimeException('Status tidak valid.');
        }

        $db = $this->db;
        $db->transBegin();

        try {
            $order = $db->query('SELECT id, status FROM orders WHERE id = ? FOR UPDATE', [$id])->getRowArray();
            if (! $order) {
                throw new RuntimeException('Pesanan tidak ditemukan.');
            }
            if ($order['status'] === 'batal') {
                throw new RuntimeException('Pesanan yang sudah dibatalkan tidak dapat diubah.');
            }

            if ($status === 'batal') {
                foreach (model(OrderItemModel::class)->where('order_id', $id)->findAll() as $it) {
                    $db->query('UPDATE produk SET stok = stok + ? WHERE id = ?', [$it['qty'], $it['produk_id']]);
                }
            }
            $this->update($id, ['status' => $status]);
            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();

            throw $e instanceof RuntimeException ? $e : new RuntimeException('Gagal mengubah status.', 0, $e);
        }
    }

    /** Pelanggan hanya boleh membatalkan pesanan miliknya yang masih pending. */
    public function batalkan(int $id, int $userId): void
    {
        $order = $this->where(['id' => $id, 'user_id' => $userId])->first();
        if (! $order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }
        if ($order['status'] !== 'pending') {
            throw new RuntimeException('Hanya pesanan berstatus menunggu pembayaran yang dapat dibatalkan.');
        }

        $this->ubahStatus($id, 'batal');
    }
}
