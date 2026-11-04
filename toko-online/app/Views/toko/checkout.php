<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>
<h3 class="mb-3">Checkout</h3>
<div class="row">
    <div class="col-md-7 mb-3"><div class="card shadow-sm"><div class="card-body">
        <form method="post" action="<?= site_url('checkout') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Alamat Pengiriman</label>
                <textarea name="alamat" rows="4" class="form-control" placeholder="Jalan, nomor, kota, kode pos" required><?= esc(old('alamat')) ?></textarea>
            </div>
            <button class="btn btn-success"><i class="fas fa-check"></i> Buat Pesanan</button>
            <a href="<?= site_url('keranjang') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div></div></div>
    <div class="col-md-5"><div class="card shadow-sm"><div class="card-header">Ringkasan Pesanan</div>
        <ul class="list-group list-group-flush">
            <?php foreach ($items as $i): ?>
                <li class="list-group-item d-flex justify-content-between"><span><?= esc($i['nama']) ?> &times; <?= $i['qty'] ?></span><span><?= rupiah($i['subtotal']) ?></span></li>
            <?php endforeach ?>
            <li class="list-group-item d-flex justify-content-between font-weight-bold"><span>Total</span><span><?= rupiah($total) ?></span></li>
        </ul>
    </div></div>
</div>
<?= $this->endSection() ?>
