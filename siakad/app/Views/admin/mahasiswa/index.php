<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <form class="form-inline" method="get">
            <input class="form-control form-control-sm mr-2" name="q" value="<?= esc($q) ?>" placeholder="Cari nama / NRP">
            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-search"></i></button>
        </form>
        <a href="<?= site_url('admin/mahasiswa/new') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card-body"><div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light"><tr><th>Foto</th><th>NRP</th><th>Nama</th><th>Angkatan</th><th>Email</th><th>Dosen Wali</th><th width="140">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?php if ($r['foto']): ?><img src="<?= base_url('uploads/foto/' . $r['foto']) ?>" width="48" height="48" class="rounded" style="object-fit:cover" alt=""><?php endif ?></td>
                    <td><?= esc($r['nrp']) ?></td>
                    <td><?= esc($r['nama']) ?></td>
                    <td><?= esc($r['angkatan']) ?></td>
                    <td><?= esc($r['email']) ?></td>
                    <td><?= esc($r['dosen_wali'] ?? '-') ?></td>
                    <td>
                        <a href="<?= site_url("admin/mahasiswa/{$r['id']}/edit") ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <?= $this->setData(['action' => "admin/mahasiswa/{$r['id']}/delete"])->include('admin/_delete') ?>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if (! $rows): ?><tr><td colspan="7" class="text-center text-muted">Belum ada data</td></tr><?php endif ?>
            </tbody>
        </table>
    </div><?= $pager->links() ?></div>
</div>
<?= $this->endSection() ?>
