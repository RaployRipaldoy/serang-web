<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-eye"></i> Detail Jenis Perlengkapan
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- Main Information -->
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title text-primary">
                            <i class="fas fa-info-circle"></i> Informasi Utama
                        </h6>
                        
                        <table class="table table-borderless">
                            <!-- <tr>
                                <td width="30%" class="fw-bold">ID</td>
                                <td width="5%">:</td>
                                <td>
                                    <span class="badge bg-secondary"><?= esc($jenisPerlengkapan['id']) ?></span>
                                </td>
                            </tr> -->
                            <tr>
                                <td class="fw-bold">Nama Perlengkapan</td>
                                <td>:</td>
                                <td>
                                    <h5 class="text-primary mb-0"><?= esc($jenisPerlengkapan['nama_perlengkapan']) ?></h5>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Jenis Perlengkapan</td>
                                <td>:</td>
                                <td>
                                    <span class="badge bg-info fs-6"><?= esc($jenisPerlengkapan['jenis_perlengkapan']) ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Metadata Information -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title text-secondary">
                            <i class="fas fa-clock"></i> Informasi Metadata
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-success">
                                        <i class="fas fa-plus-circle"></i> Data Dibuat
                                    </h6>
                                    <p class="mb-1">
                                        <strong>Tanggal:</strong><br>
                                        <?= date('l, d F Y', strtotime($jenisPerlengkapan['created_at'])) ?><br>
                                        <small class="text-muted">
                                            <?= date('H:i:s', strtotime($jenisPerlengkapan['created_at'])) ?> WIB
                                        </small>
                                    </p>
                                    <p class="mb-0">
                                        <strong>Oleh:</strong><br>
                                        <span class="badge bg-success">
                                            <?= esc($jenisPerlengkapan['created_by'] ?? 'System') ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-warning">
                                        <i class="fas fa-edit"></i> Terakhir Diubah
                                    </h6>
                                    <p class="mb-1">
                                        <strong>Tanggal:</strong><br>
                                        <?= date('l, d F Y', strtotime($jenisPerlengkapan['updated_at'])) ?><br>
                                        <small class="text-muted">
                                            <?= date('H:i:s', strtotime($jenisPerlengkapan['updated_at'])) ?> WIB
                                        </small>
                                    </p>
                                    <p class="mb-0">
                                        <strong>Oleh:</strong><br>
                                        <span class="badge bg-warning">
                                            <?= esc($jenisPerlengkapan['updated_by'] ?? 'System') ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Time Difference -->
                        <div class="mt-3">
                            <small class="text-muted">
                                <?php
                                $created = new DateTime($jenisPerlengkapan['created_at']);
                                $updated = new DateTime($jenisPerlengkapan['updated_at']);
                                $now = new DateTime();
                                
                                $diffCreated = $created->diff($now);
                                $diffUpdated = $updated->diff($now);
                                
                                echo '<i class="fas fa-calendar"></i> Dibuat ' . 
                                     ($diffCreated->days == 0 ? 'hari ini' : $diffCreated->days . ' hari yang lalu') . 
                                     ', diubah ' . 
                                     ($diffUpdated->days == 0 ? 'hari ini' : $diffUpdated->days . ' hari yang lalu');
                                ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Action Panel -->
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-cogs"></i> Aksi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('DataJenisPerlengkapan/edit/' . $jenisPerlengkapan['id']) ?>" 
                               class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Data
                            </a>
                            
                            <button type="button" 
                                    class="btn btn-danger" 
                                    onclick="confirmDelete(<?= $jenisPerlengkapan['id'] ?>, '<?= esc($jenisPerlengkapan['nama_perlengkapan']) ?>')">
                                <i class="fas fa-trash"></i> Hapus Data
                            </button>
                            
                            <hr class="my-2">
                            
                            <a href="<?= base_url('DataJenisPerlengkapan') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                            </a>
                            
                            <a href="<?= base_url('DataJenisPerlengkapan/create') ?>" class="btn btn-success">
                                <i class="fas fa-plus"></i> Tambah Data Baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistics Panel -->
                <div class="card border-info mt-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-pie"></i> Statistik
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="mb-2">
                                <strong>Data Telah Aktif</strong>
                            </div>
                            <div class="h4 text-primary">
                                <?php
                                $created = new DateTime($jenisPerlengkapan['created_at']);
                                $now = new DateTime();
                                $diff = $created->diff($now);
                                
                                if ($diff->days == 0) {
                                    echo 'Hari Ini';
                                } elseif ($diff->days < 30) {
                                    echo $diff->days . ' Hari';
                                } elseif ($diff->days < 365) {
                                    echo round($diff->days / 30) . ' Bulan';
                                } else {
                                    echo round($diff->days / 365) . ' Tahun';
                                }
                                ?>
                            </div>
                            
                            <?php if ($jenisPerlengkapan['created_at'] != $jenisPerlengkapan['updated_at']): ?>
                                <hr>
                                <div class="mb-2">
                                    <strong>Terakhir Diubah</strong>
                                </div>
                                <div class="h6 text-warning">
                                    <?php
                                    $updated = new DateTime($jenisPerlengkapan['updated_at']);
                                    $diffUpdated = $updated->diff($now);
                                    
                                    if ($diffUpdated->days == 0) {
                                        if ($diffUpdated->h == 0) {
                                            echo $diffUpdated->i . ' menit lalu';
                                        } else {
                                            echo $diffUpdated->h . ' jam lalu';
                                        }
                                    } else {
                                        echo $diffUpdated->days . ' hari lalu';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                    <h5>Apakah Anda yakin?</h5>
                </div>
                <p>Anda akan menghapus data jenis perlengkapan:</p>
                <div class="alert alert-warning">
                    <strong id="deleteItemName"></strong>
                </div>
                <p class="text-danger">
                    <small>
                        <i class="fas fa-warning"></i>
                        <strong>Peringatan:</strong> Data yang dihapus tidak dapat dikembalikan!
                    </small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Ya, Hapus Data
                </a>
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

document.addEventListener('DOMContentLoaded', function() {
    // Add some interactive effects
    const cards = document.querySelectorAll('.card');
    cards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'transform 0.2s';
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
