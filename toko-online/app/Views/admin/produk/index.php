<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <form class="form-inline" method="get">
            <input class="form-control form-control-sm mr-2" name="q" value="<?= esc($q) ?>" placeholder="Cari nama produk">
            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-search"></i></button>
        </form>
        <a href="<?= site_url('admin/produk/new') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card-body"><div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light"><tr><th>Gambar</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th width="140">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><img src="<?= esc(gambar_url($r['gambar'])) ?>" width="64" height="48" class="rounded" style="object-fit:cover" alt=""></td>
                    <td><?= esc($r['nama']) ?></td><td><?= esc($r['kategori']) ?></td><td><?= rupiah($r['harga']) ?></td><td><?= (int) $r['stok'] ?></td>
                    <td>
                        <a href="<?= site_url("admin/produk/{$r['id']}/edit") ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <?= $this->setData(['action' => "admin/produk/{$r['id']}/delete"])->include('admin/_delete') ?>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if (! $rows): ?><tr><td colspan="6" class="text-center text-muted">Belum ada data</td></tr><?php endif ?>
            </tbody>
        </table>
    </div><?= $pager->links() ?></div>
</div>
<?= $this->endSection() ?>
