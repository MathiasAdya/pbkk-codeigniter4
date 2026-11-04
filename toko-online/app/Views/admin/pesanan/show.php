<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8"><div class="card shadow mb-4"><div class="card-body">
        <table class="table">
            <thead><tr><th>Produk</th><th class="text-right">Harga</th><th>Qty</th><th class="text-right">Subtotal</th></tr></thead>
            <tbody>
            <?php foreach ($items as $i): ?>
                <tr><td><?= esc($i['nama']) ?></td><td class="text-right"><?= rupiah($i['harga']) ?></td><td><?= $i['qty'] ?></td><td class="text-right"><?= rupiah($i['harga'] * $i['qty']) ?></td></tr>
            <?php endforeach ?>
            </tbody>
            <tfoot><tr><th colspan="3" class="text-right">Total</th><th class="text-right"><?= rupiah($order['total']) ?></th></tr></tfoot>
        </table>
    </div></div></div>
    <div class="col-lg-4"><div class="card shadow mb-4"><div class="card-body">
        <p class="mb-1"><strong>Pelanggan:</strong> <?= esc($order['pelanggan']) ?> (<?= esc($order['username']) ?>)</p>
        <p class="mb-1"><strong>Tanggal:</strong> <?= esc($order['created_at']) ?></p>
        <p><strong>Alamat:</strong><br><?= nl2br(esc($order['alamat'])) ?></p>
        <p><strong>Status:</strong> <?= badge_status($order['status']) ?></p>
        <?php if ($order['status'] !== 'batal'): ?>
            <form method="post" action="<?= site_url("admin/pesanan/{$order['id']}/status") ?>">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>Ubah status</label>
                    <select name="status" class="form-control">
                        <?php foreach (STATUS_PESANAN as $k => $label): ?><option value="<?= $k ?>" <?= $order['status'] === $k ? 'selected' : '' ?>><?= $label ?></option><?php endforeach ?>
                    </select>
                    <small class="text-muted">Status "Dibatalkan" mengembalikan stok dan tidak dapat diubah lagi.</small>
                </div>
                <button class="btn btn-primary btn-block"><i class="fas fa-save"></i> Simpan Status</button>
            </form>
        <?php endif ?>
        <a href="<?= site_url('admin/pesanan') ?>" class="btn btn-secondary btn-block mt-2">Kembali</a>
    </div></div></div>
</div>
<?= $this->endSection() ?>
