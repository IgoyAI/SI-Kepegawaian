<?php
$title = 'Data Cuti';
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
        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModal">Ajukan Cuti</button>
        <table class="table table-bordered">
            <thead>
            <tr><th>ID</th><th>Nama</th><th>Tanggal Awal</th><th>Tanggal Akhir</th><th>Jenis</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            <?php foreach($cuti as $row): ?>
                <tr>
                    <td><?= esc($row['id']) ?></td>
                    <td><?= esc($row['nama']) ?></td>
                    <td><?= esc($row['tanggal_awal']) ?></td>
                    <td><?= esc($row['tanggal_akhir']) ?></td>
                    <td><?= esc($row['jenis']) ?></td>
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
                    <h5 class="modal-title" id="createModalLabel">Ajukan Cuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo view('cuti/_form', ['action' => site_url('cuti/save'), 'pegawai' => $pegawai]); ?>
                </div>
            </div>
        </div>
    </div>

    <?php foreach($cuti as $c): ?>
    <div class="modal fade" id="editModal<?= $c['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $c['id'] ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $c['id'] ?>">Edit Cuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo view('cuti/_form', ['action' => site_url('cuti/update/'.$c['id']), 'cuti' => $c, 'submit' => 'Update']); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</section>
<?php $this->endSection(); ?>
