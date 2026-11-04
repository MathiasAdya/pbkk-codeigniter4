<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php $v = static fn ($f) => esc(old($f, $row[$f] ?? '')); ?>
<div class="card shadow mb-4"><div class="card-body">
    <form method="post" enctype="multipart/form-data" action="<?= site_url($row ? "admin/mahasiswa/{$row['id']}" : 'admin/mahasiswa') ?>">
        <?= csrf_field() ?>
        <div class="form-row">
            <div class="form-group col-md-4"><label>NRP</label><input name="nrp" class="form-control" value="<?= $v('nrp') ?>" required></div>
            <div class="form-group col-md-8"><label>Nama</label><input name="nama" class="form-control" value="<?= $v('nama') ?>" required></div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4"><label>Angkatan</label><input type="number" name="angkatan" class="form-control" value="<?= $v('angkatan') ?: date('Y') ?>" required></div>
            <div class="form-group col-md-8"><label>Email</label><input type="email" name="email" class="form-control" value="<?= $v('email') ?>"></div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6"><label>Dosen Wali</label>
                <select name="dosen_wali_id" class="form-control">
                    <option value="">- Belum ditentukan -</option>
                    <?php foreach ($dosen as $d): ?>
                        <option value="<?= $d['id'] ?>" <?= (string) old('dosen_wali_id', $row['dosen_wali_id'] ?? '') === (string) $d['id'] ? 'selected' : '' ?>><?= esc($d['nama']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group col-md-6"><label>Foto (JPG/PNG/WEBP, maks 1 MB)<?= $row ? ' &ndash; kosongkan bila tidak diganti' : '' ?></label>
                <input type="file" name="foto" class="form-control-file" accept="image/*" <?= $row ? '' : 'required' ?>>
                <?php if (! empty($row['foto'])): ?><img src="<?= base_url('uploads/foto/' . $row['foto']) ?>" width="80" class="mt-2 rounded" alt=""><?php endif ?>
            </div>
        </div>
        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        <a href="<?= site_url('admin/mahasiswa') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
<?= $this->endSection() ?>
