<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 text-right"><a href="<?= site_url('admin/dosen/new') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah</a></div>
    <div class="card-body"><div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light"><tr><th>NIDN</th><th>Nama</th><th>Email</th><th width="140">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= esc($r['nidn']) ?></td><td><?= esc($r['nama']) ?></td><td><?= esc($r['email']) ?></td>
                    <td>
                        <a href="<?= site_url("admin/dosen/{$r['id']}/edit") ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <?= $this->setData(['action' => "admin/dosen/{$r['id']}/delete"])->include('admin/_delete') ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div></div>
</div>
<?= $this->endSection() ?>
