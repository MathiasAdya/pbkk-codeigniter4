<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table         = 'order_items';
    protected $allowedFields = ['order_id', 'produk_id', 'qty', 'harga'];
    protected $returnType    = 'array';

    public function byOrder(int $orderId): array
    {
        return $this->select('order_items.*, produk.nama, produk.gambar')
            ->join('produk', 'produk.id = order_items.produk_id')
            ->where('order_id', $orderId)->findAll();
    }
}
