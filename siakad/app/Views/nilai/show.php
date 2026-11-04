<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary"><?= esc($mk['kode']) ?> &ndash; <?= esc($mk['nama']) ?> (<?= $mk['sks'] ?> SKS)</h6></div>
    <div class="card-body">
        <form method="post" action="<?= site_url("nilai/{$mk['id']}") ?>">
            <?= csrf_field() ?>
            <table class="table table-bordered">
                <thead class="thead-light"><tr><th>NRP</th><th>Nama</th><th width="160">Nilai</th></tr></thead>
                <tbody>
                <?php foreach ($peserta as $p): ?>
                    <tr>
                        <td><?= esc($p['nrp']) ?></td><td><?= esc($p['nama']) ?></td>
                        <td><select name="nilai[<?= $p['id'] ?>]" class="form-control form-control-sm">
                            <option value="">-</option>
                            <?php foreach ($pilihan as $n): ?><option <?= $p['nilai'] === $n ? 'selected' : '' ?>><?= $n ?></option><?php endforeach ?>
                        </select></td>
                    </tr>
                <?php endforeach ?>
                <?php if (! $peserta): ?><tr><td colspan="3" class="text-center text-muted">Belum ada peserta</td></tr><?php endif ?>
                </tbody>
            </table>
            <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan Nilai</button>
            <a href="<?= site_url('nilai') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
