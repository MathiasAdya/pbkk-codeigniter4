<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4"><div class="card-body">
    <form method="post" action="<?= site_url($row ? "admin/kategori/{$row['id']}" : 'admin/kategori') ?>">
        <?= csrf_field() ?>
        <div class="form-group"><label>Nama Kategori</label><input name="nama" class="form-control" value="<?= esc(old('nama', $row['nama'] ?? '')) ?>" required></div>
        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        <a href="<?= site_url('admin/kategori') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
<?= $this->endSection() ?>
