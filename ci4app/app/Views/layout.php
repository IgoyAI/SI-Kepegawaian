<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'SI Kepegawaian' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .nav-sidebar .nav-link.active,
        .nav-sidebar .nav-link:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php $user = session('user'); ?>
            <?php if ($user): ?>
            <li class="nav-item d-flex align-items-center mr-2">
                <span class="text-sm font-weight-bold">
                    <?= esc($user['name']) ?> (<?= esc($user['role']) ?>)
                </span>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('auth/logout') ?>" class="nav-link">Logout</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?= site_url('dashboard') ?>" class="brand-link">
            <span class="brand-text font-weight-light">SI Kepegawaian</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <?php $user = session('user'); ?>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item"><a href="<?= site_url('dashboard') ?>" class="nav-link <?= url_is('dashboard') ? 'active' : '' ?>"><i class="nav-icon fas fa-home"></i><p>Dashboard</p></a></li>
                    <?php if ($user && $user['role'] === 'hr'): ?>
                    <li class="nav-item"><a href="<?= site_url('employees') ?>" class="nav-link <?= url_is('employees*') ? 'active' : '' ?>"><i class="nav-icon fas fa-users"></i><p>Pegawai</p></a></li>
                    <li class="nav-item"><a href="<?= site_url('attendance') ?>" class="nav-link <?= url_is('attendance*') ? 'active' : '' ?>"><i class="nav-icon fas fa-calendar-check"></i><p>Presensi</p></a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="<?= site_url('cuti') ?>" class="nav-link <?= url_is('cuti*') ? 'active' : '' ?>"><i class="nav-icon fas fa-plane"></i><p>Cuti</p></a></li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- Content Wrapper -->
    <div class="content-wrapper p-3">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?= esc($pageTitle ?? $title ?? '') ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <?php if (!isset($breadcrumbs)): ?>
                            <?php
                                $uri = service('uri');
                                $segments = $uri->getSegments();
                                $breadcrumbs = [];
                                $path = '';
                                foreach ($segments as $i => $seg) {
                                    $titleSeg = ucfirst(str_replace('-', ' ', $seg));
                                    $path .= $seg;
                                    if ($i < count($segments) - 1) {
                                        $breadcrumbs[] = ['title' => $titleSeg, 'url' => site_url($path)];
                                        $path .= '/';
                                    } else {
                                        $breadcrumbs[] = ['title' => $titleSeg];
                                    }
                                }
                            ?>
                        <?php endif; ?>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                            <?php if (!empty($breadcrumbs)): ?>
                                <?php foreach ($breadcrumbs as $bc): ?>
                                    <?php if (isset($bc['url'])): ?>
                                        <li class="breadcrumb-item"><a href="<?= esc($bc['url']) ?>"><?= esc($bc['title']) ?></a></li>
                                    <?php else: ?>
                                        <li class="breadcrumb-item active"><?= esc($bc['title']) ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="breadcrumb-item active"><?= esc($pageTitle ?? $title ?? '') ?></li>
                            <?php endif; ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->renderSection('content') ?>
    </div>
    <footer class="main-footer text-center">
        <strong>&copy; 2025 SI Kepegawaian</strong>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
