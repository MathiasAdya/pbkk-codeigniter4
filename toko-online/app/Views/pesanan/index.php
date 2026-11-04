<?= $this->extend('layouts/store') ?>
<?= $this->section('content') ?>
<h3 class="mb-3">Pesanan Saya</h3>
<div class="card shadow-sm"><div class="card-body"><div class="table-responsive">
    <table class="table table-hover">
        <thead><tr><th>No.</th><th>Tanggal</th><th class="text-right">Total</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td>#<?= $r['id'] ?></td><td><?= esc($r['created_at']) ?></td><td class="text-right"><?= rupiah($r['total']) ?></td>
                <td><?= badge_status($r['status']) ?></td>
                <td><a href="<?= site_url("pesanan/{$r['id']}") ?>" class="btn btn-sm btn-primary">Detail</a></td>
            </tr>
        <?php endforeach ?>
        <?php if (! $rows): ?><tr><td colspan="5" class="text-center text-muted">Belum ada pesanan.</td></tr><?php endif ?>
        </tbody>
    </table>
</div><?= $pager->links() ?></div></div>
<?= $this->endSection() ?>
