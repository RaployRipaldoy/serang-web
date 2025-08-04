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
