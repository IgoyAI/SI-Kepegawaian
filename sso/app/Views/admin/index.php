<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Allowed Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand-md navbar-white navbar-light">
    <div class="container">
      <a href="<?= base_url('/') ?>" class="navbar-brand">SSO Admin</a>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="<?= base_url('logout') ?>" class="nav-link">Logout</a></li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="content p-4">
      <div class="container">
        <h1>Allowed Users</h1>
        <table class="table">
          <thead>
            <tr><th>Email</th><th>Applications</th><th>Admin</th><th></th></tr>
          </thead>
          <tbody>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><?= esc($u['email']) ?></td>
              <td><?= esc(implode(', ', $u['apps'] ?? [])) ?></td>
              <td><?= !empty($u['is_admin']) ? 'Yes' : 'No' ?></td>
              <td><a href="<?= base_url('admin/delete/' . urlencode($u['email'])) ?>" class="btn btn-sm btn-danger">Delete</a></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>

        <h2>Add User</h2>
        <form method="post" action="<?= base_url('admin/add') ?>">
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Applications</label><br>
            <?php foreach ($apps as $key => $app): ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="apps[]" value="<?= esc($key) ?>" id="app-<?= esc($key) ?>">
                <label class="form-check-label" for="app-<?= esc($key) ?>"><?= esc($app['label']) ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="form-group">
            <label><input type="checkbox" name="is_admin" value="1"> Administrator</label>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url('vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>
</html>
