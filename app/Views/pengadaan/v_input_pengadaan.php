<h1>Input Data Pengadaan</h1>
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
<?php echo form_open_multipart('DataPengadaan/insertData') ?>
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
            <label>Jenis Perlengkapan:</label>
            <select name="jenis_perlengkapan" id="jenis_perlengkapan" class="form-control">
                <option value="APILL" <?= set_select('kondisi', 'Rusak') ?>>APILL</option>
                <option value="PJU" <?= set_select('kondisi', 'Rusak') ?>>PJU</option>
                <option value="Marka Jalan" <?= set_select('kondisi', 'Rusak') ?>>Marka Jalan</option>
                <option value="Rambu Jalan" <?= set_select('kondisi', 'Rusak') ?>>Rambu Jalan</option>
                <option value="Pengaman Jalan" <?= set_select('kondisi', 'Rusak') ?>>Pengaman Jalan</option>
                <option value="Pengendali Pemakai Jalan" <?= set_select('kondisi', 'Baik') ?>>Pengendali Pemakai
                    Jalan</option>
            </select>
            <p class="text-danger">
                <?php echo isset($errors['jenis_perlengkapann']) ? validation_show_error('jenis_perlengkapann') : ''; ?>
            </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Jumlah Ketersediaan:</label>
            <input class="form-control" type="number" name="jumlah_ketersediaan">
            <p class="text-danger">
                <?php echo isset($errors['jumlah_ketersediaan']) ? validation_show_error('jumlah_ketersediaan') : ''; ?>
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