<?php

const STATUS_PESANAN = [
    'pending' => 'Menunggu Pembayaran',
    'dibayar' => 'Dibayar',
    'dikirim' => 'Dikirim',
    'selesai' => 'Selesai',
    'batal'   => 'Dibatalkan',
];

const STATUS_WARNA = ['pending' => 'warning', 'dibayar' => 'info', 'dikirim' => 'primary', 'selesai' => 'success', 'batal' => 'secondary'];

if (! function_exists('user')) {
    /** Ambil data user yang sedang login dari session. */
    function user(?string $key = null)
    {
        $data = session()->get('user') ?? [];

        return $key === null ? $data : ($data[$key] ?? null);
    }
}

if (! function_exists('rupiah')) {
    function rupiah(int|string|null $angka): string
    {
        return 'Rp ' . number_format((int) $angka, 0, ',', '.');
    }
}

if (! function_exists('gambar_url')) {
    /** URL gambar produk, atau placeholder bila belum ada. */
    function gambar_url(?string $gambar): string
    {
        return $gambar ? base_url('uploads/produk/' . $gambar) : 'https://placehold.co/400x300?text=Tanpa+Gambar';
    }
}

if (! function_exists('badge_status')) {
    function badge_status(string $status): string
    {
        return '<span class="badge badge-' . (STATUS_WARNA[$status] ?? 'light') . '">' . esc(STATUS_PESANAN[$status] ?? $status) . '</span>';
    }
}
