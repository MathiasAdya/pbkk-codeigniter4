<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 text-right"><a href="<?= site_url('admin/kategori/new') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
    <div class="card-body"><div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light"><tr><th width="60">No.</th><th>Nama</th><th>Jumlah Produk</th><th width="140">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $n => $r): ?>
                <tr>
                    <td><?= $n + 1 ?></td><td><?= esc($r['nama']) ?></td><td><?= (int) $r['jumlah_produk'] ?></td>
                    <td>
                        <a href="<?= site_url("admin/kategori/{$r['id']}/edit") ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <?= $this->setData(['action' => "admin/kategori/{$r['id']}/delete"])->include('admin/_delete') ?>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if (! $rows): ?><tr><td colspan="4" class="text-center text-muted">Belum ada data</td></tr><?php endif ?>
            </tbody>
        </table>
    </div></div>
</div>
<?= $this->endSection() ?>
