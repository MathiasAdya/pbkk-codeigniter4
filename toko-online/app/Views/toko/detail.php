<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>
<nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Produk</a></li>
    <li class="breadcrumb-item"><a href="<?= site_url('/') ?>?kategori=<?= $p['kategori_id'] ?>"><?= esc($p['kategori']) ?></a></li>
    <li class="breadcrumb-item active"><?= esc($p['nama']) ?></li></ol></nav>
<div class="card shadow-sm"><div class="card-body"><div class="row">
    <div class="col-md-5 mb-3"><img src="<?= esc(gambar_url($p['gambar'])) ?>" class="img-fluid rounded" alt="<?= esc($p['nama']) ?>"></div>
    <div class="col-md-7">
        <h3><?= esc($p['nama']) ?></h3>
        <h4 class="text-primary"><?= rupiah($p['harga']) ?></h4>
        <p class="text-muted mb-1">Kategori: <?= esc($p['kategori']) ?></p>
        <p>Stok: <?= $p['stok'] > 0 ? '<span class="badge badge-success">' . (int) $p['stok'] . ' tersedia</span>' : '<span class="badge badge-danger">Habis</span>' ?></p>
        <p><?= nl2br(esc($p['deskripsi'] ?? '')) ?></p>
        <?php if ($p['stok'] > 0): ?>
            <form method="post" action="<?= site_url('keranjang/tambah') ?>" class="form-inline">
                <?= csrf_field() ?><input type="hidden" name="produk_id" value="<?= $p['id'] ?>">
                <input type="number" name="qty" value="1" min="1" max="<?= (int) $p['stok'] ?>" class="form-control mr-2" style="width:90px">
                <button class="btn btn-success"><i class="fas fa-cart-plus"></i> Tambah ke Keranjang</button>
            </form>
        <?php endif ?>
    </div>
</div></div></div>
<?= $this->endSection() ?>
