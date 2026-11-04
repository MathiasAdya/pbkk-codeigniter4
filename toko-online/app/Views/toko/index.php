<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="list-group">
            <a href="<?= site_url('/') . ($q ? '?q=' . urlencode($q) : '') ?>" class="list-group-item list-group-item-action <?= $aktif ? '' : 'active' ?>">Semua Kategori</a>
            <?php foreach ($kategori as $k): ?>
                <a href="<?= site_url('/') . '?kategori=' . $k['id'] . ($q ? '&q=' . urlencode($q) : '') ?>" class="list-group-item list-group-item-action <?= $aktif === (int) $k['id'] ? 'active' : '' ?>"><?= esc($k['nama']) ?></a>
            <?php endforeach ?>
        </div>
    </div>
    <div class="col-md-9">
        <form class="form-inline mb-4" method="get" action="<?= site_url('/') ?>">
            <?php if ($aktif): ?><input type="hidden" name="kategori" value="<?= $aktif ?>"><?php endif ?>
            <input class="form-control mr-2 flex-grow-1" name="q" value="<?= esc($q) ?>" placeholder="Cari produk...">
            <button class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
        </form>
        <div class="row">
            <?php foreach ($produk as $p): ?>
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <a href="<?= site_url("produk/{$p['id']}") ?>"><img src="<?= esc(gambar_url($p['gambar'])) ?>" class="card-img-top produk-img" alt="<?= esc($p['nama']) ?>"></a>
                        <div class="card-body">
                            <small class="text-muted"><?= esc($p['kategori']) ?></small>
                            <h6 class="card-title mb-1"><a class="text-dark" href="<?= site_url("produk/{$p['id']}") ?>"><?= esc($p['nama']) ?></a></h6>
                            <div class="font-weight-bold text-primary"><?= rupiah($p['harga']) ?></div>
                            <small class="text-muted">Stok: <?= (int) $p['stok'] ?></small>
                        </div>
                        <div class="card-footer bg-white">
                            <?php if ($p['stok'] > 0): ?>
                                <form method="post" action="<?= site_url('keranjang/tambah') ?>">
                                    <?= csrf_field() ?><input type="hidden" name="produk_id" value="<?= $p['id'] ?>"><input type="hidden" name="qty" value="1">
                                    <button class="btn btn-sm btn-success btn-block"><i class="fas fa-cart-plus"></i> Tambah</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-sm btn-secondary btn-block" disabled>Stok habis</button>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <?php if (! $produk): ?><div class="col-12"><p class="text-center text-muted py-5">Produk tidak ditemukan.</p></div><?php endif ?>
        </div>
        <?= $pager->links() ?>
    </div>
</div>
<?= $this->endSection() ?>
