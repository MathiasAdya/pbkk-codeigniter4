<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card shadow mb-4 border-left-warning"><div class="card-body">
    <b><?= esc($mahasiswa['nama']) ?></b> (<?= esc($mahasiswa['nrp']) ?>) &middot;
    Total SKS lulus: <b><?= $ipk['sks'] ?></b> &middot; IPK: <b class="text-warning h5"><?= number_format($ipk['ip'], 2) ?></b>
</div></div>
<?php foreach ($semesters as $ta => $rows): $ips = hitung_ip($rows); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= esc($ta) ?></h6>
            <span>IPS: <b><?= number_format($ips['ip'], 2) ?></b> (<?= $ips['sks'] ?> SKS dinilai)</span>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered mb-0">
                <thead class="thead-light"><tr><th>Kode</th><th>Matakuliah</th><th>SKS</th><th>Nilai</th><th>Bobot</th></tr></thead>
                <tbody>
                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><?= esc($r['kode']) ?></td><td><?= esc($r['nama']) ?></td><td><?= $r['sks'] ?></td>
                        <td><?= $r['nilai'] ?? '<span class="text-muted">belum dinilai</span>' ?></td>
                        <td><?= $r['nilai'] !== null ? number_format(NILAI_BOBOT[$r['nilai']], 1) : '-' ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endforeach ?>
<?= $this->endSection() ?>
