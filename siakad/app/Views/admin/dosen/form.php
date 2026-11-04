<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php $v = static fn ($f) => esc(old($f, $row[$f] ?? '')); ?>
<div class="card shadow mb-4"><div class="card-body">
    <form method="post" action="<?= site_url($row ? "admin/dosen/{$row['id']}" : 'admin/dosen') ?>">
        <?= csrf_field() ?>
        <div class="form-group"><label>NIDN</label><input name="nidn" class="form-control" value="<?= $v('nidn') ?>" required></div>
        <div class="form-group"><label>Nama</label><input name="nama" class="form-control" value="<?= $v('nama') ?>" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="<?= $v('email') ?>"></div>
        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        <a href="<?= site_url('admin/dosen') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
<?= $this->endSection() ?>
