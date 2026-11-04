<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 text-right"><a href="<?= site_url('admin/matakuliah/new') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
    <div class="card-body"><div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light"><tr><th>Kode</th><th>Nama</th><th>SKS</th><th>Semester</th><th>Dosen Pengampu</th><th width="140">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= esc($r['kode']) ?></td><td><?= esc($r['nama']) ?></td><td><?= $r['sks'] ?></td><td><?= $r['semester'] ?></td><td><?= esc($r['dosen'] ?? '-') ?></td>
                    <td>
                        <a href="<?= site_url("admin/matakuliah/{$r['id']}/edit") ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <?= $this->setData(['action' => "admin/matakuliah/{$r['id']}/delete"])->include('admin/_delete') ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div></div>
</div>
<?= $this->endSection() ?>
