<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>
<h3 class="mb-3">Keranjang Belanja</h3>
<?php if (! $items): ?>
    <div class="alert alert-info">Keranjang masih kosong. <a href="<?= site_url('/') ?>">Mulai belanja</a></div>
<?php else: ?>
<div class="card shadow-sm mb-3"><div class="card-body">
    <form method="post" action="<?= site_url('keranjang/update') ?>">
        <?= csrf_field() ?>
        <div class="table-responsive"><table class="table">
            <thead><tr><th>Produk</th><th class="text-right">Harga</th><th width="120">Qty</th><th class="text-right">Subtotal</th><th width="60"></th></tr></thead>
            <tbody>
            <?php foreach ($items as $i): ?>
                <tr>
                    <td><a href="<?= site_url("produk/{$i['id']}") ?>"><?= esc($i['nama']) ?></a>
                        <?php if ($i['qty'] > $i['stok']): ?><br><small class="text-danger">Stok tersisa <?= (int) $i['stok'] ?></small><?php endif ?></td>
                    <td class="text-right"><?= rupiah($i['harga']) ?></td>
                    <td><input type="number" name="qty[<?= $i['id'] ?>]" value="<?= $i['qty'] ?>" min="0" max="<?= max(1, (int) $i['stok']) ?>" class="form-control form-control-sm"></td>
                    <td class="text-right"><?= rupiah($i['subtotal']) ?></td>
                    <td><button type="submit" class="btn btn-sm btn-danger" formaction="<?= site_url("keranjang/hapus/{$i['id']}") ?>" title="Hapus"><i class="fas fa-trash"></i></button></td>
                </tr>
            <?php endforeach ?>
            </tbody>
            <tfoot><tr><th colspan="3" class="text-right">Total</th><th class="text-right"><?= rupiah($total) ?></th><th></th></tr></tfoot>
        </table></div>
        <button class="btn btn-outline-primary"><i class="fas fa-sync"></i> Perbarui Keranjang</button>
        <a href="<?= site_url('checkout') ?>" class="btn btn-success float-right"><i class="fas fa-credit-card"></i> Checkout</a>
    </form>
</div></div>
<?php endif ?>
<?= $this->endSection() ?>
