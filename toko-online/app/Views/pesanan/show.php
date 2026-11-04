<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>
<h3 class="mb-3">Pesanan #<?= $order['id'] ?> <?= badge_status($order['status']) ?></h3>
<div class="card shadow-sm mb-3"><div class="card-body">
    <p class="mb-1"><strong>Tanggal:</strong> <?= esc($order['created_at']) ?></p>
    <p><strong>Alamat:</strong><br><?= nl2br(esc($order['alamat'])) ?></p>
    <table class="table">
        <thead><tr><th>Produk</th><th class="text-right">Harga</th><th>Qty</th><th class="text-right">Subtotal</th></tr></thead>
        <tbody>
        <?php foreach ($items as $i): ?>
            <tr><td><?= esc($i['nama']) ?></td><td class="text-right"><?= rupiah($i['harga']) ?></td><td><?= $i['qty'] ?></td><td class="text-right"><?= rupiah($i['harga'] * $i['qty']) ?></td></tr>
        <?php endforeach ?>
        </tbody>
        <tfoot><tr><th colspan="3" class="text-right">Total</th><th class="text-right"><?= rupiah($order['total']) ?></th></tr></tfoot>
    </table>
    <a href="<?= site_url('pesanan') ?>" class="btn btn-secondary">Kembali</a>
    <?php if ($order['status'] === 'pending'): ?>
        <form method="post" action="<?= site_url("pesanan/{$order['id']}/batal") ?>" class="d-inline" onsubmit="return confirm('Batalkan pesanan ini?')">
            <?= csrf_field() ?><button class="btn btn-danger"><i class="fas fa-times"></i> Batalkan Pesanan</button>
        </form>
    <?php endif ?>
</div></div>
<?= $this->endSection() ?>
