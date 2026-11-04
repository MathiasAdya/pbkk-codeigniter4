<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAKAD - Sistem Informasi Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fas fa-university"></i> SIAKAD</a>
        <a class="btn btn-light btn-sm ml-auto" href="<?= site_url('login') ?>"><i class="fas fa-sign-in-alt"></i> Login</a>
    </div>
</nav>
<header class="py-5 bg-light border-bottom">
    <div class="container text-center py-4">
        <h1 class="display-4 font-weight-bold">Sistem Informasi Akademik</h1>
        <p class="lead text-muted">Kelola mahasiswa, dosen, matakuliah, KRS, dan nilai dalam satu aplikasi berbasis CodeIgniter 4.</p>
        <a class="btn btn-primary btn-lg" href="<?= site_url('login') ?>">Masuk ke Sistem</a>
    </div>
</header>
<section class="container py-5">
    <div class="row text-center">
        <?php foreach ($stats as $label => $count): ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100"><div class="card-body">
                    <h2 class="display-4 text-primary"><?= $count ?></h2>
                    <p class="text-muted mb-0"><?= $label ?> terdaftar</p>
                </div></div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="row mt-4">
        <?php foreach ([
            ['user-shield', 'Admin', 'CRUD data mahasiswa (dengan upload foto), dosen, dan matakuliah.'],
            ['chalkboard-teacher', 'Dosen', 'Melihat matakuliah yang diampu dan menginput nilai peserta.'],
            ['user-graduate', 'Mahasiswa', 'Mengisi KRS (maks. 24 SKS), melihat KHS, IPS, dan IPK.'],
        ] as [$icon, $role, $desc]): ?>
            <div class="col-md-4 mb-3">
                <h5><i class="fas fa-<?= $icon ?> text-primary"></i> <?= $role ?></h5>
                <p class="text-muted"><?= $desc ?></p>
            </div>
        <?php endforeach ?>
    </div>
</section>
<footer class="py-3 bg-dark text-white-50 text-center small">SIAKAD &copy; <?= date('Y') ?> &middot; PBKK (D)</footer>
</body>
</html>
