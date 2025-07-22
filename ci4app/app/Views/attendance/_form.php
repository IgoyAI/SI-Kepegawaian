<form method="post" action="<?= $action ?>">
    <?= csrf_field() ?>
    <div class="form-group">
        <label>Pegawai</label>
        <select name="pegawai_id" class="form-control" required>
            <option value="">-- pilih pegawai --</option>
            <?php foreach($pegawai as $p): ?>
                <option value="<?= $p['id'] ?>" <?= isset($presensi['pegawai_id']) && $presensi['pegawai_id'] == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="<?= esc($presensi['tanggal'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Hadir" <?= isset($presensi['status']) && $presensi['status']=='Hadir' ? 'selected' : '' ?>>Hadir</option>
            <option value="Sakit" <?= isset($presensi['status']) && $presensi['status']=='Sakit' ? 'selected' : '' ?>>Sakit</option>
            <option value="Izin" <?= isset($presensi['status']) && $presensi['status']=='Izin' ? 'selected' : '' ?>>Izin</option>
            <option value="Tidak Hadir" <?= isset($presensi['status']) && $presensi['status']=='Tidak Hadir' ? 'selected' : '' ?>>Tidak Hadir</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary"><?= $submit ?? 'Simpan' ?></button>
</form>
