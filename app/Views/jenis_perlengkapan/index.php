<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-list"></i> Data Jenis Perlengkapan
        </h5>
    </div>
    <div class="card-body">
        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Toolbar -->
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="<?= base_url('DataJenisPerlengkapan/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
            <div class="col-md-6">
                <form method="GET" action="<?= base_url('DataJenisPerlengkapan') ?>">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari nama atau jenis perlengkapan..." 
                               value="<?= esc($keyword ?? '') ?>">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if ($keyword): ?>
                            <a href="<?= base_url('DataJenisPerlengkapan') ?>" class="btn btn-outline-danger">
                                <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 30%">Nama Perlengkapan</th>
                        <th style="width: 25%">Jenis Perlengkapan</th>
                        <th style="width: 15%">Dibuat</th>
                        <th style="width: 15%">Diperbarui</th>
                        <th style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jenisPerlengkapan)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($jenisPerlengkapan as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= esc($item['nama_perlengkapan']) ?></strong>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= esc($item['jenis_perlengkapan']) ?></span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?><br>
                                        oleh: <?= esc($item['created_by'] ?? 'System') ?>
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($item['updated_at'])) ?><br>
                                        oleh: <?= esc($item['updated_by'] ?? 'System') ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('DataJenisPerlengkapan/detail/' . $item['id']) ?>" 
                                           class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('DataJenisPerlengkapan/edit/' . $item['id']) ?>" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                onclick="confirmDelete(<?= $item['id'] ?>, '<?= esc($item['nama_perlengkapan']) ?>')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <h5>Tidak ada data</h5>
                                    <?php if ($keyword): ?>
                                        <p>Pencarian "<?= esc($keyword) ?>" tidak ditemukan</p>
                                        <a href="<?= base_url('DataJenisPerlengkapan') ?>" class="btn btn-secondary">
                                            Tampilkan Semua Data
                                        </a>
                                    <?php else: ?>
                                        <p>Belum ada data jenis perlengkapan</p>
                                        <a href="<?= base_url('DataJenisPerlengkapan/create') ?>" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Tambah Data Pertama
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Summary Info -->
        <?php if (!empty($jenisPerlengkapan)): ?>
            <div class="mt-3">
                <small class="text-muted">
                    Menampilkan <?= count($jenisPerlengkapan) ?> data
                    <?= $keyword ? ' hasil pencarian untuk "' . esc($keyword) . '"' : '' ?>
                </small>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data jenis perlengkapan:</p>
                <p><strong id="deleteItemName"></strong></p>
                <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteConfirmBtn').href = '<?= base_url('DataJenisPerlengkapan/delete/') ?>' + id;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Auto hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
