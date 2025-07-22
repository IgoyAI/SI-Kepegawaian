<?php
$title = 'Data Presensi';
$this->extend('layout');
?>
<?php $this->section('content'); ?>
<section class="content">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>
        <form class="form-inline mb-2" method="get">
            <select name="pegawai_id" class="form-control mr-2">
                <option value="">Semua Pegawai</option>
                <?php foreach($pegawai as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= $filter['pegawai_id']==$p['id']?'selected':'' ?>><?= esc($p['nama']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="date" name="tanggal" class="form-control mr-2" value="<?= esc($filter['tanggal']) ?>">
            <select name="status" class="form-control mr-2">
                <option value="">Semua Status</option>
                <option <?= $filter['status']=='Hadir'?'selected':'' ?>>Hadir</option>
                <option <?= $filter['status']=='Sakit'?'selected':'' ?>>Sakit</option>
                <option <?= $filter['status']=='Izin'?'selected':'' ?>>Izin</option>
                <option <?= $filter['status']=='Tidak Hadir'?'selected':'' ?>>Tidak Hadir</option>
            </select>
            <button class="btn btn-secondary" type="submit">Filter</button>
        </form>
        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal">Input Presensi</button>
        <table class="table table-bordered">
            <thead>
            <tr><th>ID</th><th>Nama</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php foreach($presensi as $row): ?>
                <tr>
                    <td><?= esc($row['id']) ?></td>
                    <td><?= esc($row['nama']) ?></td>
                    <td><?= esc($row['tanggal']) ?></td>
                    <td><?= esc($row['status']) ?></td>
                    <td><button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#editModal<?= $row['id'] ?>">Edit</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Input Presensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo view('attendance/_form', ['action' => site_url('attendance/save'), 'pegawai' => $pegawai]); ?>
                </div>
            </div>
        </div>
    </div>

    <?php foreach($presensi as $pr): ?>
    <div class="modal fade" id="editModal<?= $pr['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $pr['id'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $pr['id'] ?>">Edit Presensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo view('attendance/_form', ['action' => site_url('attendance/update/'.$pr['id']), 'presensi' => $pr, 'pegawai' => $pegawai, 'submit' => 'Update']); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</section>
<?php $this->endSection(); ?>
