<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php $v = static fn ($f) => esc(old($f, $row[$f] ?? '')); ?>
<div class="card shadow mb-4"><div class="card-body">
    <form method="post" enctype="multipart/form-data" action="<?= site_url($row ? "admin/produk/{$row['id']}" : 'admin/produk') ?>">
        <?= csrf_field() ?>
        <div class="form-row">
            <div class="form-group col-md-8"><label>Nama Produk</label><input name="nama" class="form-control" value="<?= $v('nama') ?>" required></div>
            <div class="form-group col-md-4"><label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="">- Pilih kategori -</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id'] ?>" <?= (string) old('kategori_id', $row['kategori_id'] ?? '') === (string) $k['id'] ? 'selected' : '' ?>><?= esc($k['nama']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6"><label>Harga (Rp)</label><input type="number" min="0" name="harga" class="form-control" value="<?= $v('harga') ?>" required></div>
            <div class="form-group col-md-6"><label>Stok</label><input type="number" min="0" name="stok" class="form-control" value="<?= $v('stok') ?>" required></div>
        </div>
        <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" rows="4" class="form-control"><?= $v('deskripsi') ?></textarea></div>
        <div class="form-group"><label>Gambar (JPG/PNG/WEBP, maks 2 MB)<?= $row ? ' &ndash; kosongkan bila tidak diganti' : '' ?></label>
            <input type="file" name="gambar" class="form-control-file" accept="image/*">
            <?php if (! empty($row['gambar'])): ?><img src="<?= esc(gambar_url($row['gambar'])) ?>" width="120" class="mt-2 rounded" alt=""><?php endif ?>
        </div>
        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        <a href="<?= site_url('admin/produk') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
<?= $this->endSection() ?>
