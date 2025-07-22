<?php
$title = 'Ajukan Cuti';
$this->extend('layout');
?>
<?php $this->section('content'); ?>
<section class="content">
    <div class="container-fluid">
        <form method="post" action="<?= site_url('cuti/save') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Pegawai</label>
                <select name="pegawai_id" class="form-control" required>
                    <option value="">-- pilih pegawai --</option>
                    <?php foreach($pegawai as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= esc($p['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jenis</label>
                <input type="text" name="jenis" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Alasan</label>
                <textarea name="alasan" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</section>
<?php $this->endSection(); ?>
