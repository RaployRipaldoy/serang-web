<div class="container mt-5">
    <h3>Detail Pelaporan</h3>
    <hr>

    <div class="card shadow p-4">
        <div class="row mb-3">
            <div class="col-md-4 font-weight-bold">Email:</div>
            <div class="col-md-8"><?= esc($pelaporan['email']) ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 font-weight-bold">No Handphone:</div>
            <div class="col-md-8"><?= esc($pelaporan['no_hp']) ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 font-weight-bold">Keterangan:</div>
            <div class="col-md-8"><?= esc($pelaporan['keterangan']) ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 font-weight-bold">Foto Bukti:</div>
            <div class="col-md-8">
                <?php if (!empty($pelaporan['foto_bukti'])): ?>
                    <img src="<?= base_url('uploads/' . $pelaporan['foto_bukti']) ?>" class="img-fluid" style="max-width: 300px;">
                <?php else: ?>
                    <span class="text-muted">Tidak ada foto</span>
                <?php endif; ?>
            </div>
        </div>

        <a href="<?= site_url('DataPelaporan') ?>" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
