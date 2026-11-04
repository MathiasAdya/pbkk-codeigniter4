<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="row">
    <?php foreach ($stats as [$label, $value, $icon, $color]): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-<?= $color ?> shadow h-100 py-2"><div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-<?= $color ?> text-uppercase mb-1"><?= $label ?></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $value ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-<?= $icon ?> fa-2x text-gray-300"></i></div>
                </div>
            </div></div>
        </div>
    <?php endforeach ?>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Selamat datang, <?= esc(user('nama')) ?></h6></div>
    <div class="card-body d-flex align-items-center">
        <?php if (! empty($profil['foto'])): ?>
            <img src="<?= base_url('uploads/foto/' . $profil['foto']) ?>" class="rounded-circle mr-4" width="96" height="96" style="object-fit:cover" alt="foto">
        <?php endif ?>
        <div>
            <p class="mb-1">Anda login sebagai <b><?= esc(user('role')) ?></b> (username <code><?= esc(user('username')) ?></code>).</p>
            <?php if (isset($profil['nrp'])): ?><p class="mb-0">NRP <?= esc($profil['nrp']) ?> &middot; Angkatan <?= esc($profil['angkatan']) ?></p><?php endif ?>
            <?php if (isset($profil['nidn'])): ?><p class="mb-0">NIDN <?= esc($profil['nidn']) ?> &middot; <?= esc($profil['email']) ?></p><?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
