<?php
$title = 'Edit Presensi';
$this->extend('layout');
?>
<?php $this->section('content'); ?>
<section class="content">
    <div class="container-fluid">
        <form method="post" action="<?= site_url('attendance/update/' . $presensi['id']) ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Pegawai</label>
                <select name="pegawai_id" class="form-control" required>
                    <?php foreach($pegawai as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id']==$presensi['pegawai_id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?= esc($presensi['tanggal']) ?>" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option <?= $presensi['status']=='Hadir'?'selected':'' ?>>Hadir</option>
                    <option <?= $presensi['status']=='Sakit'?'selected':'' ?>>Sakit</option>
                    <option <?= $presensi['status']=='Izin'?'selected':'' ?>>Izin</option>
                    <option <?= $presensi['status']=='Tidak Hadir'?'selected':'' ?>>Tidak Hadir</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</section>
<?php $this->endSection(); ?>
