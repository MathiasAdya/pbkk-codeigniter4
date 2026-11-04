<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4"><div class="card-body">
    <table class="table table-bordered">
        <thead class="thead-light"><tr><th>Kode</th><th>Matakuliah</th><th>SKS</th><th>Peserta (<?= \App\Models\KrsModel::TAHUN_AJARAN ?>)</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= esc($r['kode']) ?></td><td><?= esc($r['nama']) ?></td><td><?= $r['sks'] ?></td><td><?= $r['peserta'] ?> mahasiswa</td>
                <td><a href="<?= site_url("nilai/{$r['id']}") ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Input Nilai</a></td>
            </tr>
        <?php endforeach ?>
        <?php if (! $rows): ?><tr><td colspan="5" class="text-center text-muted">Belum ada matakuliah yang diampu</td></tr><?php endif ?>
        </tbody>
    </table>
</div></div>
<?= $this->endSection() ?>
