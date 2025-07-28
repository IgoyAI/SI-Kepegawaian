<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enterprise SSO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <style>
    .app-btn {
      width: 160px;
      height: 120px;
      display: inline-flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand-md navbar-white navbar-light">
    <div class="container">
    <ul class="navbar-nav ml-auto">
      <?php if (session()->has('user')): ?>
        <?php if (session('is_admin')): ?>
          <li class="nav-item"><a href="<?= base_url('admin') ?>" class="nav-link">Admin</a></li>
        <?php endif; ?>

        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <img src="<?= session('user.picture') ?>" class="img-size-32 mr-2 img-circle" alt="User Image">
            <?= esc(session('user.name')) ?>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="<?= base_url('logout') ?>" class="dropdown-item">Logout</a>
          </div>
        </li>
      <?php else: ?>
        <li class="nav-item"><a href="<?= base_url('login') ?>" class="nav-link">Login</a></li>
      <?php endif; ?>
    </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="content p-4">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1>Welcome to the Enterprise SSO</h1>
            <?php if (session()->has('user')): ?>
              <p>You are logged in as <?= esc(session('user.email')) ?>.</p>
              <div class="alert alert-info mt-3" role="alert">
                Welcome! Select an application below to continue.
              </div>
              <div class="row justify-content-center">

                <?php foreach ($apps as $id => $app): ?>
                  <div class="col-sm-4 col-md-3 text-center mb-3">
                    <a href="<?= base_url('launch/' . $id) ?>" class="btn btn-app app-btn bg-<?= esc($app['color']) ?>">
                      <i class="<?= esc($app['icon']) ?> fa-2x mb-2"></i>
                      <?= esc($app['label']) ?>
                    </a>
                  </div>
                <?php endforeach; ?>

              </div>
            <?php else: ?>
              <p>Please login using your Google account.</p>
              <a href="<?= base_url('login') ?>" class="btn btn-primary">Login with Google</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url('vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>
</html>
