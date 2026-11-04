<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">KRS <?= \App\Models\KrsModel::TAHUN_AJARAN ?></h6>
                <span class="badge badge-<?= $totalSks >= \App\Models\KrsModel::MAX_SKS ? 'danger' : 'info' ?>"><?= $totalSks ?> / <?= \App\Models\KrsModel::MAX_SKS ?> SKS</span>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-light"><tr><th>Kode</th><th>Matakuliah</th><th>SKS</th><th>Dosen</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($krs as $r): ?>
                        <tr>
                            <td><?= esc($r['kode']) ?></td><td><?= esc($r['nama']) ?></td><td><?= $r['sks'] ?></td><td><?= esc($r['dosen'] ?? '-') ?></td>
                            <td><?php if ($r['nilai'] === null): ?>
                                <form method="post" action="<?= site_url("krs/{$r['id']}/delete") ?>" onsubmit="return confirm('Batalkan matakuliah ini?')">
                                    <?= csrf_field() ?><button class="btn btn-sm btn-outline-danger">Batal</button>
                                </form>
                            <?php else: ?><span class="badge badge-success"><?= $r['nilai'] ?></span><?php endif ?></td>
                        </tr>
                    <?php endforeach ?>
                    <?php if (! $krs): ?><tr><td colspan="5" class="text-center text-muted">KRS masih kosong</td></tr><?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Matakuliah Tersedia</h6></div>
            <div class="card-body">
                <?php foreach ($tersedia as $mk): ?>
                    <form method="post" action="<?= site_url('krs') ?>" class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <?= csrf_field() ?><input type="hidden" name="matakuliah_id" value="<?= $mk['id'] ?>">
                        <div><b><?= esc($mk['kode']) ?></b> <?= esc($mk['nama']) ?><br><small class="text-muted"><?= $mk['sks'] ?> SKS &middot; Smt <?= $mk['semester'] ?> &middot; <?= esc($mk['dosen'] ?? '-') ?></small></div>
                        <button class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Ambil</button>
                    </form>
                <?php endforeach ?>
                <?php if (! $tersedia): ?><p class="text-muted mb-0">Semua matakuliah sudah diambil.</p><?php endif ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
