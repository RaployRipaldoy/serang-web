<h1>Form Pelaporan/Pengaduan</h1>
<hr>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php $errors = validation_errors() ?>
<?= form_open_multipart('DataPelaporan/insertData') ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" class="form-control" name="email" value="<?= old('email') ?>">
            <p class="text-danger">
                <?= isset($errors['email']) ? validation_show_error('email') : '' ?>
            </p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>No HP:</label>
            <input type="text" class="form-control" name="no_hp" value="<?= old('no_hp') ?>">
            <p class="text-danger">
                <?= isset($errors['no_hp']) ? validation_show_error('no_hp') : '' ?>
            </p>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea name="keterangan" rows="3" class="form-control"><?= old('keterangan') ?></textarea>
            <p class="text-danger">
                <?= isset($errors['keterangan']) ? validation_show_error('keterangan') : '' ?>
            </p>
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label>Foto Pengaduan</label>
            <input type="file" class="form-control" name="foto_bukti" accept="image/" onchange="previewImage(event)">
            <p class="text-danger">
                <?php echo isset($errors['foto_bukti']) ? validation_show_error('foto_bukti') : ''; ?>
            </p>
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label>Preview Foto:</label><br>
            <img id="preview-img" src="#" alt="Preview Foto Bukti" class="img-fluid img-thumbnail"
                style="max-height: 200px; display: none;">
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">Kirim</button>
<button type="reset" class="btn btn-success">Reset</button>

<?= form_close() ?>

<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();

        reader.onload = function () {
            const imgElement = document.getElementById('preview-img');
            imgElement.src = reader.result;
            imgElement.style.display = 'block';
        };

        if (input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>