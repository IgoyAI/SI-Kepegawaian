<form method="post" action="<?= $action ?>">
    <?= csrf_field() ?>
    <?php if (!isset($cuti)): ?>
        <div class="form-group">
            <label>Pegawai</label>
            <select name="pegawai_id" class="form-control" required>
                <option value="">-- pilih pegawai --</option>
                <?php foreach($pegawai as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= isset($selected) && $selected==$p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Awal</label>
            <input type="date" name="tanggal_awal" class="form-control" value="<?= esc($tanggal_awal ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control" value="<?= esc($tanggal_akhir ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Jenis</label>
            <input type="text" name="jenis" class="form-control" value="<?= esc($jenis ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Alasan</label>
            <textarea name="alasan" class="form-control"><?= esc($alasan ?? '') ?></textarea>
        </div>
    <?php else: ?>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Menunggu" <?= isset($cuti['status']) && $cuti['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                <option value="Disetujui" <?= isset($cuti['status']) && $cuti['status'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                <option value="Ditolak" <?= isset($cuti['status']) && $cuti['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
            </select>
        </div>
        <div class="form-group">
            <label>Alasan Penolakan</label>
            <textarea name="alasan_penolakan" class="form-control"><?= esc($cuti['alasan_penolakan'] ?? '') ?></textarea>
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary"><?= $submit ?? 'Simpan' ?></button>
</form>
