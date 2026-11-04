<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-store fa-3x text-primary mb-3"></i>
                        <h1 class="h4 text-gray-900">Login Toko Online</h1>
                        <p class="small text-muted">Masuk sebagai admin atau pelanggan</p>
                    </div>
                    <?= $this->include('layouts/_alerts') ?>
                    <form class="user" method="post" action="<?= site_url('login') ?>">
                        <?= csrf_field() ?>
                        <div class="form-group"><input type="text" name="username" class="form-control form-control-user" placeholder="Username" value="<?= esc(old('username')) ?>" required autofocus></div>
                        <div class="form-group"><input type="password" name="password" class="form-control form-control-user" placeholder="Password" required></div>
                        <button class="btn btn-primary btn-user btn-block">Login</button>
                    </form>
                    <div class="text-center mb-2"><a class="small" href="<?= site_url('register') ?>">Belum punya akun? Daftar</a></div>
                    <hr>
                    <div class="text-center"><a class="small" href="<?= site_url('/') ?>">&larr; Kembali ke beranda</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/vendor/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
