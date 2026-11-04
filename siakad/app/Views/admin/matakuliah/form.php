<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php $v = static fn ($f) => esc(old($f, $row[$f] ?? '')); ?>
<div class="card shadow mb-4"><div class="card-body">
    <form method="post" action="<?= site_url($row ? "admin/matakuliah/{$row['id']}" : 'admin/matakuliah') ?>">
        <?= csrf_field() ?>
        <div class="form-row">
            <div class="form-group col-md-3"><label>Kode</label><input name="kode" class="form-control" value="<?= $v('kode') ?>" required></div>
            <div class="form-group col-md-9"><label>Nama</label><input name="nama" class="form-control" value="<?= $v('nama') ?>" required></div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3"><label>SKS</label><input type="number" min="1" max="6" name="sks" class="form-control" value="<?= $v('sks') ?>" required></div>
            <div class="form-group col-md-3"><label>Semester</label><input type="number" min="1" max="8" name="semester" class="form-control" value="<?= $v('semester') ?>" required></div>
            <div class="form-group col-md-6"><label>Dosen Pengampu</label>
                <select name="dosen_id" class="form-control">
                    <option value="">- Belum ditentukan -</option>
                    <?php foreach ($dosen as $d): ?>
                        <option value="<?= $d['id'] ?>" <?= (string) old('dosen_id', $row['dosen_id'] ?? '') === (string) $d['id'] ? 'selected' : '' ?>><?= esc($d['nama']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        <a href="<?= site_url('admin/matakuliah') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
<?= $this->endSection() ?>
