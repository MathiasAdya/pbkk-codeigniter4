<?php
$menu = [
    ['admin/kategori', 'tags', 'Kategori'],
    ['admin/produk', 'box', 'Produk'],
    ['admin/pesanan', 'shopping-cart', 'Pesanan'],
];
$current = uri_string();
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('admin') ?>">
        <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-store"></i></div>
        <div class="sidebar-brand-text mx-3">Toko Admin</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?= $current === 'admin' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= site_url('admin') ?>"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Kelola</div>
    <?php foreach ($menu as [$uri, $icon, $label]): ?>
        <li class="nav-item <?= str_starts_with($current, $uri) ? 'active' : '' ?>">
            <a class="nav-link" href="<?= site_url($uri) ?>"><i class="fas fa-fw fa-<?= $icon ?>"></i><span><?= $label ?></span></a>
        </li>
    <?php endforeach ?>
    <hr class="sidebar-divider">
    <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>"><i class="fas fa-fw fa-external-link-alt"></i><span>Lihat Toko</span></a></li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline"><button class="rounded-circle border-0" id="sidebarToggle"></button></div>
</ul>
