<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Toko Online') ?> | Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>.produk-img{height:180px;object-fit:cover}</style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('/') ?>"><i class="fas fa-store"></i> Toko Online</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>">Produk</a></li>
                <?php if (user('role') === 'customer'): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('pesanan') ?>">Pesanan Saya</a></li>
                <?php elseif (user('role') === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('admin') ?>">Panel Admin</a></li>
                <?php endif ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('keranjang') ?>"><i class="fas fa-shopping-cart"></i> Keranjang
                        <span class="badge badge-light"><?= (new \App\Libraries\Cart())->count() ?></span></a>
                </li>
                <?php if (session('logged_in')): ?>
                    <li class="nav-item"><span class="navbar-text mx-2"><i class="fas fa-user"></i> <?= esc(user('nama')) ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('logout') ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('register') ?>">Daftar</a></li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <?= $this->include('layouts/_alerts') ?>
    <?= $this->renderSection('content') ?>
</div>
<footer class="text-center text-muted small py-4 mt-5">Toko Online &copy; <?= date('Y') ?> &middot; CodeIgniter <?= \CodeIgniter\CodeIgniter::CI_VERSION ?></footer>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
