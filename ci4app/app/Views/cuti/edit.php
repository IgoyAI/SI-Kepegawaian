<?php
$title = 'Edit Cuti';
$this->extend('layout');
?>
<?php $this->section('content'); ?>
<section class="content">
    <div class="container-fluid">
        <form method="post" action="<?= site_url('cuti/update/' . $cuti['id']) ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Menunggu" <?= $cuti['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="Disetujui" <?= $cuti['status'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                    <option value="Ditolak" <?= $cuti['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
            <div class="form-group">
                <label>Alasan Penolakan</label>
                <textarea name="alasan_penolakan" class="form-control"><?= esc($cuti['alasan_penolakan']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</section>
<?php $this->endSection(); ?>
