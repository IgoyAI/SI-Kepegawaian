<?php
$title = 'Dashboard';
$this->extend('layout');
?>
<?php $this->section('content'); ?>
<div class="text-center">
    <h2 class="mb-4 animate__animated animate__fadeInDown">Hello, <?= esc($user['name']) ?>!</h2>
    <p class="lead">You are logged in as <strong><?= esc($user['role']) ?></strong>.</p>
    <?php if ($user['role'] === 'hr'): ?>
    <p class="lead">Sebagai HR Anda dapat mengelola pegawai dan presensi.</p>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="welcomeModalLabel">Welcome</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Selamat datang, <?= esc($user['name']) ?>!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
  $('#welcomeModal').modal('show');
});
</script>
<?php $this->endSection(); ?>
