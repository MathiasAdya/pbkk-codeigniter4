<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'SIAKAD') ?> | SIAKAD</title>
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
<div id="wrapper">
    <?= $this->include('layouts/_sidebar') ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>
                <span class="text-gray-600 small">Tahun Ajaran <?= \App\Models\KrsModel::TAHUN_AJARAN ?></span>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= esc(user('nama')) ?> <span class="badge badge-primary"><?= esc(user('role')) ?></span></span>
                            <i class="fas fa-user-circle fa-2x text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow">
                            <a class="dropdown-item" href="<?= site_url('logout') ?>"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800"><?= esc($title ?? '') ?></h1>
                <?= $this->include('layouts/_alerts') ?>
                <?= $this->renderSection('content') ?>
            </div>
        </div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto"><div class="copyright text-center my-auto"><span>SIAKAD &copy; <?= date('Y') ?> &middot; CodeIgniter <?= \CodeIgniter\CodeIgniter::CI_VERSION ?></span></div></div>
        </footer>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/vendor/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/js/sb-admin-2.min.js"></script>
</body>
</html>
