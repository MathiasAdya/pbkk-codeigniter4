<?php

namespace App\Database\Seeds;

use App\Models\KategoriModel;
use App\Models\ProdukModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class TokoSeeder extends Seeder
{
    public function run()
    {
        $users = model(UserModel::class);
        $users->insert(['username' => 'admin', 'password' => 'admin123', 'nama' => 'Administrator', 'email' => 'admin@toko.test', 'role' => 'admin']);
        $users->insert(['username' => 'budi', 'password' => 'budi123', 'nama' => 'Budi Santoso', 'email' => 'budi@toko.test', 'role' => 'customer']);

        $kategori = model(KategoriModel::class);
        $ids      = [];
        foreach (['Elektronik', 'Fashion', 'Buku'] as $nama) {
            $ids[$nama] = $kategori->insert(['nama' => $nama]);
        }

        $produk = [
            ['Elektronik', 'Headphone Bluetooth', 'Headphone nirkabel dengan baterai tahan 30 jam.', 350000, 25],
            ['Elektronik', 'Power Bank 10000 mAh', 'Power bank ringkas dengan dua port USB.', 185000, 40],
            ['Fashion', 'Kaos Polos Katun', 'Kaos katun combed 30s, nyaman dipakai sehari-hari.', 75000, 100],
            ['Fashion', 'Sepatu Sneakers', 'Sneakers casual untuk pria dan wanita.', 420000, 15],
            ['Buku', 'Pemrograman Web dengan CodeIgniter', 'Panduan membangun aplikasi web dengan CodeIgniter 4.', 95000, 30],
            ['Buku', 'Dasar-dasar Basis Data', 'Konsep basis data relasional dan SQL.', 88000, 20],
        ];
        $model = model(ProdukModel::class);
        foreach ($produk as [$kat, $nama, $deskripsi, $harga, $stok]) {
            $model->insert(['kategori_id' => $ids[$kat], 'nama' => $nama, 'deskripsi' => $deskripsi, 'harga' => $harga, 'stok' => $stok]);
        }
    }
}
