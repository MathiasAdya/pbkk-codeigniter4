<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form class="form-inline" method="get">
            <select name="status" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                <option value="">Semua status</option>
                <?php foreach (STATUS_PESANAN as $k => $label): ?><option value="<?= $k ?>" <?= $status === $k ? 'selected' : '' ?>><?= $label ?></option><?php endforeach ?>
            </select>
        </form>
    </div>
    <div class="card-body"><div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light"><tr><th>No.</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Status</th><th width="90">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td>#<?= $r['id'] ?></td><td><?= esc($r['created_at']) ?></td><td><?= esc($r['pelanggan']) ?></td>
                    <td><?= rupiah($r['total']) ?></td><td><?= badge_status($r['status']) ?></td>
                    <td><a href="<?= site_url("admin/pesanan/{$r['id']}") ?>" class="btn btn-sm btn-primary">Detail</a></td>
                </tr>
            <?php endforeach ?>
            <?php if (! $rows): ?><tr><td colspan="6" class="text-center text-muted">Belum ada pesanan</td></tr><?php endif ?>
            </tbody>
        </table>
    </div><?= $pager->links() ?></div>
</div>
<?= $this->endSection() ?>
