<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php $cards = [
    ['Produk', $stat['produk'], 'box', 'primary'],
    ['Pesanan', $stat['pesanan'], 'shopping-cart', 'info'],
    ['Pendapatan', rupiah($stat['pendapatan']), 'money-bill-wave', 'success'],
    ['Pelanggan', $stat['pelanggan'], 'users', 'warning'],
]; ?>
<div class="row">
    <?php foreach ($cards as [$label, $nilai, $icon, $warna]): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-<?= $warna ?> shadow h-100 py-2"><div class="card-body"><div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-<?= $warna ?> text-uppercase mb-1"><?= $label ?></div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($nilai) ?></div>
                </div>
                <div class="col-auto"><i class="fas fa-<?= $icon ?> fa-2x text-gray-300"></i></div>
            </div></div></div>
        </div>
    <?php endforeach ?>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3 font-weight-bold text-primary">Pesanan Terbaru</div>
    <div class="card-body"><div class="table-responsive"><table class="table table-sm">
        <thead><tr><th>No.</th><th>Pelanggan</th><th>Total</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($terbaru as $r): ?>
            <tr><td>#<?= $r['id'] ?></td><td><?= esc($r['pelanggan']) ?></td><td><?= rupiah($r['total']) ?></td><td><?= badge_status($r['status']) ?></td>
                <td><a href="<?= site_url("admin/pesanan/{$r['id']}") ?>" class="btn btn-sm btn-primary">Detail</a></td></tr>
        <?php endforeach ?>
        <?php if (! $terbaru): ?><tr><td colspan="5" class="text-center text-muted">Belum ada pesanan</td></tr><?php endif ?>
        </tbody>
    </table></div></div>
</div>
<?= $this->endSection() ?>
