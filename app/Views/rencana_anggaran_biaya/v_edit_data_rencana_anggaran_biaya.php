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
<?php echo form_open_multipart('DataRencanaAnggaranBiaya/updateData/' . $rencana_anggaran_biaya['id']) ?>
<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label>Nama Perlengkapan:</label>
            <input class="form-control" name="nama_perlengkapan" value="<?= $rencana_anggaran_biaya['nama_perlengkapan'] ?>">
            <p class="text-danger">
                <?= isset($errors['nama_perlengkapan']) ? validation_show_error('nama_perlengkapan') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Jumlah Unit:</label>
            <input class="form-control" type="number" name="jumlah_unit" value="<?= $rencana_anggaran_biaya['jumlah_unit'] ?>">
            <p class="text-danger">
                <?= isset($errors['jumlah_unit']) ? validation_show_error('jumlah_unit') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Biaya:</label>
            <input class="form-control" type="number" name="biaya" value="<?= $rencana_anggaran_biaya['biaya'] ?>">
            <p class="text-danger">
                <?= isset($errors['biaya']) ? validation_show_error('biaya') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea class="form-control" name="keterangan" rows="3"><?= $rencana_anggaran_biaya['keterangan'] ?></textarea>
            <p class="text-danger">
                <?= isset($errors['keterangan']) ? validation_show_error('keterangan') : ''; ?>
            </p>
        </div>
</div>

<button type="submit" class="btn btn-primary">Update</button>
<a href="<?= base_url('DataRencanaAnggaranBiaya') ?>" class="btn btn-secondary">Kembali</a>

<?php echo form_close() ?>
