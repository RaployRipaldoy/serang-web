<h1>Edit Data Pengadaan Jalan</h1>
<hr>
</hr>

<?php
if (session()->getFlashdata('pesan')) {
    echo '<div class="alert alert-success">';
    echo session()->getFlashdata('pesan');
    echo '</div>';
}
?>
<?php $errors = validation_errors(); ?>
<?php echo form_open_multipart('DataPengadaan/updateData/' . $pengadaan['id']) ?>
<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label>Nama Perlengkapan:</label>
            <input class="form-control" name="nama_perlengkapan" value="<?= $pengadaan['nama_perlengkapan'] ?>">
            <p class="text-danger">
                <?= isset($errors['nama_perlengkapan']) ? validation_show_error('nama_perlengkapan') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Jenis Perlengkapan:</label>
            <select name="jenis_perlengkapan" id="jenis_perlengkapan" class="form-control">
                <option value="APILL" <?= ($pengadaan['jenis_perlengkapan'] == 'APILL') ? 'selected' : ''; ?>>APILL</option>
                <option value="PJU" <?= ($pengadaan['jenis_perlengkapan'] == 'PJU') ? 'selected' : ''; ?>>PJU</option>
                <option value="Marka Jalan" <?= ($pengadaan['jenis_perlengkapan'] == 'Marka Jalan') ? 'selected' : ''; ?>>Marka Jalan</option>
                <option value="Rambu Jalan" <?= ($pengadaan['jenis_perlengkapan'] == 'Rambu Jalan') ? 'selected' : ''; ?>>Rambu Jalan</option>
                <option value="Pengaman Jalan" <?= ($pengadaan['jenis_perlengkapan'] == 'Pengaman Jalan') ? 'selected' : ''; ?>>Pengaman Jalan</option>
                <option value="Pengendali Pemakai Jalan" <?= ($pengadaan['jenis_perlengkapan'] == 'Pengendali Pemakai Jalan') ? 'selected' : ''; ?>>Pengendali Pemakai Jalan</option>
            </select>
            <p class="text-danger">
                <?= isset($errors['jenis_perlengkapan']) ? validation_show_error('jenis_perlengkapan') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Jumlah Ketersediaan:</label>
            <input class="form-control" type="number" name="jumlah_ketersediaan" value="<?= $pengadaan['jumlah_ketersediaan'] ?>">
            <p class="text-danger">
                <?= isset($errors['jumlah_ketersediaan']) ? validation_show_error('jumlah_ketersediaan') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea class="form-control" name="keterangan" rows="3"><?= $pengadaan['keterangan'] ?></textarea>
            <p class="text-danger">
                <?= isset($errors['keterangan']) ? validation_show_error('keterangan') : ''; ?>
            </p>
        </div>
</div>

<button type="submit" class="btn btn-primary">Update</button>
<a href="<?= base_url('DataPengadaan') ?>" class="btn btn-secondary">Kembali</a>

<?php echo form_close() ?>
