<h1>Input Data Rencana Anggaran Biaya</h1>
<hr>
</hr>

<?php
if (session()->getFlashdata('pesan')) {
    echo '<div class="alert alert-success">';
    echo session()->getFlashdata('pesan');
    echo '</div>';
}
?>
<?php $errors = validation_errors() ?>
<?php echo form_open_multipart('DataRencanaAnggaranBiaya/insertData') ?>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Nama Perlengkapan:</label>
            <input class="form-control" name="nama_perlengkapan">
            <p class="text-danger">
                <?php echo isset($errors['nama_perlengkapan']) ? validation_show_error('nama_perlengkapan') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Jumlah Unit:</label>
            <input class="form-control" type="number" name="jumlah_unit">
            <p class="text-danger">
                <?php echo isset($errors['jumlah_unit']) ? validation_show_error('jumlah_unit') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Biaya:</label>
            <input class="form-control" type="number" name="biaya">
            <p class="text-danger">
                <?php echo isset($errors['biaya']) ? validation_show_error('biaya') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea class="form-control" name="keterangan" rows="3"></textarea>
            <p class="text-danger">
                <?php echo isset($errors['keterangan']) ? validation_show_error('keterangan') : ''; ?>
            </p>
        </div>
    </div>  
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<button type="reset" class="btn btn-success">Reset</button>

<?php echo form_close() ?>